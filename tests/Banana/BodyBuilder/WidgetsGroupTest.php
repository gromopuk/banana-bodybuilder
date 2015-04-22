<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder;

/**
 * Class WidgetsGroupTest
 *
 * Tests for class Banana\BodyBuilder\WidgetsGroup
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class WidgetsGroupTest extends \PHPUnit_Framework_TestCase
{

    public function testExtendsWidget()
    {
        $this->assertInstanceOf(Widget::class, new \TestWidgetsGroup());
    }

    public function testSetHasGetWidgets()
    {
        $widgets = new \TestWidgetsGroup();

        $this->assertFalse($widgets->hasWidget('test'));
        $this->assertNull($widgets->getWidget('test'));
        $this->assertEquals([], $widgets->getWidgets());

        $widget = new \TestWidget();
        $widgets->setWidget('test', $widget);

        $this->assertTrue($widgets->hasWidget('test'));
        $this->assertNotNull($widgets->getWidget('test'));
        $this->assertEquals($widget, $widgets->getWidget('test'));
        $this->assertArrayHasKey('test', $widgets->getWidgets());
        $this->assertEquals($widget, $widgets->getWidgets()['test']);
    }

    public function testSetContextAsParent()
    {
        $widgets = new \TestWidgetsGroup();
        $widget = new \TestWidget();
        $widgets->setWidget('test', $widget);

        $this->assertNotNull($widget->getContext()->getParent());
        $this->assertEquals($widgets->getContext(), $widget->getContext()->getParent());
    }

    public function testBuildLayout()
    {
        $widgets = new \TestWidgetsGroup();
        $widget = new \TestWidget();
        $widgets->setWidget('test', $widget);

        $layout = $widgets->buildLayout();

        $this->assertArrayHasKey('test', $layout->getIncludedLayouts());
        $this->assertEquals($widget->buildLayout(), $layout->getIncludedLayouts()['test']);
    }

}
