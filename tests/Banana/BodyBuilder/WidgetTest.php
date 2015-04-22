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
 * Class WidgetTest
 *
 * Tests for class Banana\BodyBuilder\Widget
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class WidgetTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildLayoutFromString()
    {
        $this->assertEquals(Rendering\Template\Type::STRING, (new StringWidget())->buildLayout()->getTemplateType());
    }

    public function testBuildLayoutFromFile()
    {
        $this->assertEquals(Rendering\Template\Type::FILE,  (new TemplateWidget())->buildLayout()->getTemplateType());
    }

    public function testBuildLayoutFromFileInsteadString()
    {
        $this->assertEquals(Rendering\Template\Type::FILE,  (new TemplateAndStringWidget())->buildLayout()->getTemplateType());
    }

    public function testBuildMethodCalled()
    {
        $layout = (new StringWidget())->buildLayout();

        $this->assertTrue($layout->getBlock()->hasVariable('test_from_build'));
        $this->assertEquals('this value set in build method', $layout->getBlock()->getVariable('test_from_build'));

    }

    public function testGetTemplateString()
    {
        $wg = new TemplateWidget();

        $this->assertNull($wg->getTemplateString());
    }

    public function testGetContext()
    {
        $widget = new Widget();
        $context = $widget->getContext();

        $this->assertNotNull($context);
        $this->assertInstanceOf(Widget\Context::class, $context);
        $this->assertEquals($context, $widget->getContext());
    }

}

class StringWidget extends Widget
{
    public function getTemplateString()
    {
        return "Template";
    }
    public function build(Widget\Block $block)
    {
        $block->setVariable('test_from_build', 'this value set in build method');
    }
}
class TemplateWidget extends Widget
{
    public function getTemplateFile()
    {
        return 'template.tpl';
    }
}
class TemplateAndStringWidget extends Widget
{
    public function getTemplateFile()
    {
        return 'template.tpl';
    }
    public function getTemplateString()
    {
        return "Template";
    }
}
