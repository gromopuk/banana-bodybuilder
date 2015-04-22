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

    public function testSetGetExtension()
    {
        $map = new Map('', '.tpl');

        $this->assertEquals('.tpl', $map->getExtension());
    }

    /**
     * @requires OS Linux
     */
    public function testSetGetTemplatePathLinux()
    {
        $map1 = new Map('/path/to/templates', '');
        $map2 = new Map('/path/to/templates/', '');
        $map3 = new Map('\path\to\templates', '');
        $map4 = new Map('\path\to\templates\\', '');
        $expected = '/path/to/templates/';

        $this->assertEquals($expected, $map1->getTemplatesPath());
        $this->assertEquals($expected, $map2->getTemplatesPath());
        $this->assertEquals($expected, $map3->getTemplatesPath());
        $this->assertEquals($expected, $map4->getTemplatesPath());
    }

    /**
     * @requires OS WIN32|WINNT
     */
    public function testSetGetTemplatePathWin()
    {
        $map1 = new Map('/path/to/templates', '');
        $map2 = new Map('/path/to/templates/', '');
        $map3 = new Map('\path\to\templates', '');
        $map4 = new Map('\path\to\templates\\', '');
        $expected = '\path\to\templates\\';

        $this->assertEquals($expected, $map1->getTemplatesPath());
        $this->assertEquals($expected, $map2->getTemplatesPath());
        $this->assertEquals($expected, $map3->getTemplatesPath());
        $this->assertEquals($expected, $map4->getTemplatesPath());
    }

    /**
     * @requires OS Linux
     */
    public function testGetTemplateFilePathLinux()
    {
        $templatePath = '/path/to/templates/';
        $extension = '.tpl';
        $map = new Map($templatePath, $extension);
        $equiv = '/path/to/templates/some/template.tpl';
        $equiv_small = '/path/to/templates/template.tpl';

        $this->assertEquals($equiv, $map->getTemplateFilePath('/some/template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('\some\template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('some/template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('some\template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('\template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('/template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('template'));
    }

    /**
     * @requires OS WIN32|WINNT
     */
    public function testGetTemplateFilePathWin()
    {
        $templatePath = '\path\to\templates/';
        $extension = '.tpl';
        $map = new Map($templatePath, $extension);
        $equiv = '\path\to\templates\some\template.tpl';
        $equiv_small = '\path\to\templates\template.tpl';

        $this->assertEquals($equiv, $map->getTemplateFilePath('/some/template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('\some\template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('some/template'));
        $this->assertEquals($equiv, $map->getTemplateFilePath('some\template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('\template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('/template'));
        $this->assertEquals($equiv_small, $map->getTemplateFilePath('template'));
    }

}
