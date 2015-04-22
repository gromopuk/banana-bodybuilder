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

use Banana\BodyBuilder\Rendering\Template\Map as TemplateMap;
use Banana\BodyBuilder\Widget;

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
        $renderer = new BodyBuilder\Rendering\Engine\Native(new TemplateMap("/"));
        $bb = new BodyBuilder();
        $bb->setRenderingEngine($renderer);

        $this->assertEquals($renderer, $bb->getRenderingEngine());
    }

    public function testIfRenderingEngineNotInstalledException()
    {
        $this->setExpectedException(\RuntimeException::class);
        (new BodyBuilder())->build(new Widget());
    }

    public function testAssertRenderingEngineNotInstalledException()
    {
        $this->setExpectedException(\RuntimeException::class);
        (new BodyBuilder())->assertRenderingEngineInstalled();
    }

    public function testAssertRenderingEngineNotInstalledNoException()
    {
        $bb = new BodyBuilder();
        $bb->setRenderingEngine(new BodyBuilder\Rendering\Engine\Native(new TemplateMap("/")));
        $bb->assertRenderingEngineInstalled();
    }

    public function testBuild()
    {
        $bb = new BodyBuilder();
        $bb->setRenderingEngine(new BodyBuilder\Rendering\Engine\Native(new TemplateMap("/")));
        $bb->build(new TestWidget());
    }

}

class TestWidget extends Widget
{
    public function getTemplateString()
    {
        return 'Template string';
    }
}
