<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Template;

/**
 * Class MapTest
 *
 * Tests for class Banana\BodyBuilder\Rendering\Template\Map
 *
 * @package Banana\BodyBuilder\Rendering\Template
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class MapTest extends \PHPUnit_Framework_TestCase
{

    public function testMapImplementsMapInterface()
    {
        $map = new Map('/', '.tpl');

        $this->assertInstanceOf(MapInterface::class, $map);
    }

    public function testSetGetTemplatePathAndExtension()
    {
        $map = new Map('/path/to/templates/', '.tpl');

        $this->assertEquals('/path/to/templates', $map->getTemplatesPath());
        $this->assertEquals('.tpl', $map->getExtension());
    }

    public function testGetTemplateFilePath()
    {
        $templatePath = '/path/to/templates/';
        $extension = '.tpl';
        $map = new Map($templatePath, $extension);

        $this->assertEquals('/path/to/templates/some/template.tpl', $map->getTemplateFilePath('/some/template'));
        $this->assertEquals('/path/to/templates/some/template.tpl', $map->getTemplateFilePath('\some\template'));
        $this->assertEquals('/path/to/templates/some/template.tpl', $map->getTemplateFilePath('some/template'));
        $this->assertEquals('/path/to/templates/some/template.tpl', $map->getTemplateFilePath('some\template'));
        $this->assertEquals('/path/to/templates/template.tpl', $map->getTemplateFilePath('\template'));
        $this->assertEquals('/path/to/templates/template.tpl', $map->getTemplateFilePath('/template'));
        $this->assertEquals('/path/to/templates/template.tpl', $map->getTemplateFilePath('template'));
    }

}
