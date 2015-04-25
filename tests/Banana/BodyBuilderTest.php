<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana;

use Banana\BodyBuilder\Rendering\EngineInterface;
use Banana\BodyBuilder\Rendering\LayoutInterface;
use Banana\BodyBuilder\Rendering\Template;
use Banana\BodyBuilder\Rendering\Template\FormatterInterface;
use Banana\BodyBuilder\Rendering\Template\Map as TemplateMap;

/**
 * Class BodyBuilderTest
 *
 * Tests for class Banana\BodyBuilder
 *
 * @package Banana
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class BodyBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetRenderingEngine()
    {
        $renderer = new TestRenderingEngine(new TemplateMap("/"));
        $bb = new BodyBuilder();
        $bb->setRenderingEngine($renderer);

        $this->assertEquals($renderer, $bb->getRenderingEngine());
    }

    /*public function testIfRenderingEngineNotInstalledException()
    {
        $this->setExpectedException(\RuntimeException::class);
    }*/

    public function testAssertRenderingEngineNotInstalledException()
    {
        $this->setExpectedException(\RuntimeException::class);
        (new BodyBuilder())->assertRenderingEngineInstalled();
    }

    public function testAssertRenderingEngineNotInstalledNoException()
    {
        $bb = new BodyBuilder();
        $bb->setRenderingEngine(new TestRenderingEngine(new TemplateMap("/")));
        $bb->assertRenderingEngineInstalled();
    }

    public function testBuild()
    {
        $bb = new BodyBuilder();
        $bb->setRenderingEngine(new TestRenderingEngine(new TemplateMap("/")));
    }

}

class TestRenderingEngine implements EngineInterface
{

    const RESULT = 'Test rendering engine result';

    /**
     * @param \Banana\BodyBuilder\Rendering\Template\MapInterface $templateMap
     */
    public function __construct(Template\MapInterface $templateMap)
    {
    }

    /**
     * @param LayoutInterface $layout
     *
     * @return void
     */
    public function render(LayoutInterface $layout)
    {
        echo self::RESULT;
    }

    /**
     * @param LayoutInterface $layout
     *
     * @return string
     */
    public function fetch(LayoutInterface $layout)
    {
        return self::RESULT;
    }

}
