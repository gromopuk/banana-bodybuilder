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
        $this->assertEquals(Rendering\Template\Type::STRING, (new StringWidget())->getLayout()->getTemplateType());
    }

    public function testBuildLayoutFromFile()
    {
        $this->assertEquals(Rendering\Template\Type::FILE,  (new TemplateWidget())->getLayout()->getTemplateType());
    }

    public function testBuildLayoutFromFileInsteadString()
    {
        $this->assertEquals(Rendering\Template\Type::FILE,  (new TemplateAndStringWidget())->getLayout()->getTemplateType());
    }

    public function testBuildMethodCalled()
    {
        $layout = (new StringWidget())->getLayout();

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
        $widget = new \TestWidgetAbstract();
        $context = $widget->getContext();

        $this->assertNotNull($context);
        $this->assertInstanceOf(Widget\Context::class, $context);
        $this->assertEquals($context, $widget->getContext());
    }

    public function testCreateLayoutNoTemplateException()
    {
        $wg = new ErrorWidget();

        $this->setExpectedException(\RuntimeException::class);
        $wg->getLayout();
    }

}

class StringWidget extends WidgetAbstract
{
    public function getTemplateString()
    {
        return "Template";
    }

    protected function buildBlock(Rendering\Block $block)
    {
        $block->setVariable('test_from_build', 'this value set in build method');
    }
}

class TemplateWidget extends WidgetAbstract
{
    public function getTemplateFile()
    {
        return 'template.tpl';
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Block $block
     *
     * @return void
     */
    protected function buildBlock(Rendering\Block $block)
    {
    }
}

class TemplateAndStringWidget extends WidgetAbstract
{
    public function getTemplateFile()
    {
        return 'template.tpl';
    }
    public function getTemplateString()
    {
        return "Template";
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Block $block
     *
     * @return void
     */
    protected function buildBlock(Rendering\Block $block)
    {
    }
}

class ErrorWidget extends WidgetAbstract
{

    /**
     * @param \Banana\BodyBuilder\Rendering\Block $block
     *
     * @return void
     */
    protected function buildBlock(Rendering\Block $block)
    {
    }
}