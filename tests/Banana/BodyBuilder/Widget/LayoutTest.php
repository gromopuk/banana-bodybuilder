<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Widget;

use Banana\BodyBuilder\Rendering\Template\Type as TemplateType;
use Banana\BodyBuilder\Rendering\LayoutInterface;

/**
 * Class LayoutTest
 *
 * Tests for class Banana\BodyBuilder\Widget\Layout
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class LayoutTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateFromTemplateFile()
    {
        $template = '/path/to/file';
        $layout = Layout::createFromFile($template);

        $this->assertEquals($template, $layout->getTemplate());
        $this->assertEquals(TemplateType::FILE, $layout->getTemplateType());
    }

    public function testCreateFromString()
    {
        $template = "{{SOME TEMPLATE AS STRING}}";
        $layout = Layout::createFromString($template);

        $this->assertEquals($template, $layout->getTemplate());
        $this->assertEquals(TemplateType::STRING, $layout->getTemplateType());
    }

    public function testImplementsLayoutInterface()
    {
        $this->assertInstanceOf(LayoutInterface::class, new Layout(TemplateType::STRING, ""));
    }

    public function testGetBlock()
    {
        $layout = new Layout(TemplateType::STRING, "");
        $block = $layout->getBlock();

        $this->assertNotNull($block);
        $this->assertInstanceOf(Block::class, $block);
    }

    public function testUnsupportedTemplateTypeException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new Layout('unsupported_type', '');
    }

    public function testGetVariables()
    {
        $layout = new Layout(TemplateType::STRING, '');

        $this->assertEquals([], $layout->getVariables());

        $layout->getBlock()->setVariable('test', 123);

        $this->assertArrayHasKey('test', $layout->getVariables());
        $this->assertEquals(123, $layout->getVariables()['test']);
    }

    public function testIncludeLayout()
    {
        $layout = new Layout(TemplateType::STRING, "");

        $this->assertEquals([], $layout->getIncludedLayouts());

        $inner = new Layout(TemplateType::STRING, "");
        $layout->includeLayout('position', $inner);

        $this->assertArrayHasKey('position', $layout->getIncludedLayouts());
        $this->assertEquals($inner, $layout->getIncludedLayouts()['position']);
    }

}
