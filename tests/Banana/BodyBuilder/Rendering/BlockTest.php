<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering;

/**
 * Class BlockTest
 *
 * Tests for class Banana\BodyBuilder\Rendering\Block
 *
 * @package Banana\BodyBuilder\Rendering\Layout
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class BlockTest extends \PHPUnit_Framework_TestCase
{

    public function testHasGetUndefinedVariable()
    {
        $block = new Block();
        $name = 'variable';

        $this->assertFalse($block->hasVariable($name));
        $this->assertNull($block->getVariable($name));
    }

    public function testSetHasGetVariable()
    {
        $block = new Block();
        $name = 'variable';
        $value = 123;
        $block->setVariable($name, $value);

        $this->assertTrue($block->hasVariable($name));
        $this->assertEquals($block->getVariable($name), $value);
    }

    public function testSetVariableWithExistingBlockNameException()
    {
        $block = new Block();
        $name = 'variable';
        $block->addBlock($name);

        $this->setExpectedException(\InvalidArgumentException::class);
        $block->setVariable($name, 123);
    }

    public function testUndefinedBlock()
    {
        $block = new Block();
        $name = 'block';

        $this->assertFalse($block->hasBlock($name));
        $this->assertNull($block->getBlocks($name));
    }

    public function testAddHasGetBlock()
    {
        $block = new Block();
        $name = 'block';
        $innerBlock = new Block();
        $block->addBlock($name, $innerBlock);

        $this->assertTrue($block->hasBlock($name));
        $this->assertTrue(is_array($block->getBlocks($name)));
        $this->assertTrue(count($block->getBlocks($name)) == 1);
        $this->assertEquals($block->getBlocks($name)[0], $innerBlock);
    }

    public function testAddAnotherBlockAtName()
    {
        $block = new Block();
        $name = 'test';
        $block->addBlock($name);
        $block->addBlock($name);

        $this->assertTrue($block->hasBlock($name));
        $this->assertTrue(count($block->getBlocks($name)) == 2);
    }

    public function testAddBlockWithExistingVariableNameException()
    {
        $block = new Block();
        $name = 'block';
        $block->setVariable($name, 123);

        $this->setExpectedException(\InvalidArgumentException::class);
        $block->addBlock($name);
    }

    public function testAddBlockReturnsNewBlockInstance()
    {
        $block = new Block();
        $innerBlock = $block->addBlock('test');

        $this->assertInstanceOf(Block::class, $innerBlock);
        $this->assertTrue($innerBlock !== $block);
    }

    public function testAddBlockReturnsGivenBlockInstance()
    {
        $block = new Block();
        $innerBlock = new Block();
        $returnedBlock = $block->addBlock('test', $innerBlock);

        $this->assertInstanceOf(Block::class, $returnedBlock);
        $this->assertTrue($innerBlock === $returnedBlock);
    }

    public function testGetAllBlocks()
    {
        $block = new Block();

        $this->assertEquals($block->getAllBlocks(), []);

        $block->addBlock('first');
        $block->addBlock('second');
        $block->addBlock('second');
        $blocks = $block->getAllBlocks();

        $this->assertTrue(is_array($blocks));
        $this->assertEquals(count($blocks), 2);
        $this->assertArrayHasKey('first', $blocks);
        $this->assertArrayHasKey('second', $blocks);
        $this->assertTrue(is_array($blocks['first']));
        $this->assertEquals(count($blocks['first']), 1);
        $this->assertTrue(is_array($blocks['second']));
        $this->assertEquals(count($blocks['second']), 2);
    }

    public function testToArrayVariable()
    {
        $block = new Block();
        $variable = 'var';
        $value = 123;
        $block->setVariable($variable, $value);

        $this->assertTrue(is_array($block->toArray()));
        $this->assertArrayHasKey($variable, $block->toArray());
        $this->assertEquals($value, $block->toArray()[$variable]);
    }

    public function testToArrayBlock()
    {
        $block = new Block();
        $name = 'block';
        $variable = 'var';
        $value = 'value';
        $inner = $block->addBlock($name);
        $inner->setVariable($variable, $value);
        $block->addBlock($name);
        $array = $block->toArray();

        $this->assertTrue(is_array($array));
        $this->assertArrayHasKey($name, $array);
        $this->assertEquals(count($array[$name]), 2);
        $this->assertArrayHasKey($variable, $array[$name][0]);
        $this->assertEquals($value, $array[$name][0][$variable]);
        $this->assertArrayNotHasKey($variable, $array[$name][1]);
    }

}
