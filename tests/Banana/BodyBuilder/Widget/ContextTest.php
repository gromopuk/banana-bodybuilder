<?php

namespace Banana\BodyBuilder\Widget;

/**
 * Class contextTest
 *
 * Tests for class Banana\BodyBuilder\Widget\Context
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class ContextTest extends \PHPUnit_Framework_TestCase
{

    public function testHasGetScalarValueNegative()
    {
        $context = new Context();

        $this->assertFalse($context->has('value'));
        $this->assertNull($context->get('value'));
    }

    public function testSetHasGetScalarValuePositive()
    {
        $context = new Context();
        $context->set('value', 1);

        $this->assertEquals($context->get('value'), 1);
        $this->assertTrue($context->has('value'));
    }

    public function testSetScalarValueNegative()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $context = new Context();
        $context->set('name', new \stdClass());
    }

    public function testSetHasGetCallablePositive()
    {
        $context = new Context();
        $context->set('callable_value', function() {return 1;});

        $this->assertTrue($context->has('callable_value'));
        $this->assertEquals($context->get('callable_value'), 1);
    }

    public function testExecuteCallableInGetNegative()
    {
        $this->setExpectedException(\UnexpectedValueException::class);

        $context = new Context();
        $context->set('callable', function() { return new \stdClass();});
        $context->get('callable');
    }

    public function testUnsetVariableAndCallablePositive()
    {
        $context = new Context();
        $context->set('value', function() {return 1;});
        $context->set('value', 2);
        $context->set('callable', 3);
        $context->set('callable', function() {return 4;});

        $this->assertEquals($context->get('value'), 2);
        $this->assertEquals($context->get('callable'), 4);
    }

    public function testSetHasGetParentNegative()
    {
        $context = new Context();

        $this->assertFalse($context->hasParent());
    }

    public function testSetHasGetParentPositive()
    {
        $context = new Context();
        $parent = new Context();
        $context->setParent($parent);

        $this->assertTrue($context->hasParent());
        $this->assertEquals($context->getParent(), $parent);
    }

    public function testSetHasGetScalarValueFromParent()
    {
        $parent = new Context();
        $parent->set('parent_value', 1);
        $parent->set('context_value', 2);
        $context = new Context();
        $context->setParent($parent);
        $context->set('context_value', 3);

        $this->assertTrue($context->has('parent_value'));
        $this->assertEquals($context->get('parent_value'), 1);
        $this->assertEquals($parent->get('context_value'), 2);
        $this->assertEquals($context->get('context_value'), 3);
    }

}