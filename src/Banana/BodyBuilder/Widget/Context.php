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

/**
 * Class Context
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Context
{

    /** @var Context */
    protected $parent;
    /** @var array */
    protected $values = [];
    /** @var callable[] */
    protected $callable = [];

    /**
     * Register value or callable into scope
     *
     * Supported value types are scalar, null, array, \ArrayAccess, \Iterator or callable instance, which should
     * return one of supported types except callable
     *
     * Callable or value, registered under the same name in current scope, will be replaced by given value or callable
     *
     * @param string                                                           $name  Variable name
     * @param int|float|string|bool|array|null|\ArrayAccess|\Iterator|callable $value Value of supported type
     *                                                                                or callable
     *
     * @return Context Current scope instance to use as Fluent interface
     *
     * @throws \InvalidArgumentException If unsupported value type is given
     */
    public function set($name, $value)
    {
        $name = (string)$name;
        if (is_callable($value)) {
            $this->setCallable($name, $value);
        } else {
            $this->setValue($name, $value);
        }
        return $this;
    }

    /**
     * Set callable in context
     *
     * Callable will be called once at first call of method self::get() with name of this callable and result of
     * callable execution will be set as value into current scope with same name, callable itself will be unset from
     * scope
     *
     * Callable MUST return value of one of supported types: scalar, null, array, \ArrayAccess, \Iterator
     *
     * Callable MUST NOT return callable
     *
     * Value, registered under the same name in current scope, will be replaced by given callable
     *
     * @param string   $name     Name of value under which the result of callable call will be registered in context
     * @param callable $callable Callable
     */
    protected function setCallable($name, callable $callable)
    {
        $this->callable[$name] = $callable;
        $this->unsetValue($name);
    }

    /**
     * Unset value from context
     *
     * @param string $name Name of value to be unset
     *
     * @return void
     */
    protected function unsetValue($name)
    {
        unset($this->values[$name]);
    }

    /**
     * Set value in context
     *
     * Supported value types are scalar, null, array, instance of \ArrayAccess or \Iterator interface
     *
     * Callable, registered under the same name in current scope, will be replaced by given value
     *
     * @param string                                                           $name  Name of value
     * @param int|float|string|bool|array|null|\ArrayAccess|\Iterator|callable $value Value of supported type
     *
     * @return void
     *
     * @throws \InvalidArgumentException If unsupported value type is given
     */
    protected function setValue($name, $value)
    {
        if (is_scalar($value) || is_array($value) || $value === null || $value instanceof \ArrayAccess || $value instanceof \Iterator) {
            $this->values[$name] = $value;
            $this->unsetCallable($name);
        } else {
            throw new \InvalidArgumentException("Value must be scalar, array, null, \\ArrayAccess or \\Iterator instance");
        }
    }

    /**
     * Unset callable from context
     *
     * @param string $name Name of callable to be unset
     *
     * @return void
     */
    protected function unsetCallable($name)
    {
        unset($this->callable[$name]);
    }

    /**
     * Returns value, registered under requested name or NULL if no value or callable is registered
     *
     * If under requested name is registered callable, it will be called once at first call of method and result of
     * callable execution will be set as value into current context with same name, callable itself will be unset from
     * context
     *
     * @param string $name Name of requested value
     *
     * @return int|float|string|bool|array|null|\ArrayAccess|\Iterator
     *
     * @throws \UnexpectedValueException If callable, registered under requested name, returns unsupported value type
     */
    public function get($name)
    {
        $name = (string)$name;
        if ($this->hasValue($name)) {
            return $this->values[$name];
        } else if ($this->hasCallable($name)) {
            try {
                $this->setValue($name, $this->executeCallable($name));
            } catch (\InvalidArgumentException $e) {
                throw new \UnexpectedValueException("Callable has return value of unsupported type", 0, $e);
            }
            return $this->get($name);
        } else if ($this->hasParent()) {
            return $this->getParent()->get($name);
        } else {
            return null;
        }
    }

    /**
     * Checks is value is registered under given name in current context
     *
     * @param string $name Name of value to check
     *
     * @return bool
     */
    protected function hasValue($name)
    {
        return isset($this->values[$name]);
    }

    /**
     * Checks is callable is registered under given name in current context
     *
     * @param string $name Name of callable to check
     *
     * @return bool
     */
    protected function hasCallable($name)
    {
        return isset($this->callable[$name]);
    }

    /**
     * Returns result of callable execution, which registered in context under given name
     *
     * Method does not check is callable registered by itself
     *
     * @param string $name Name of registered callable
     *
     * @return int|float|string|bool|array|null|\ArrayAccess|\Iterator
     */
    protected function executeCallable($name)
    {
        return call_user_func($this->callable[$name]);
    }

    /**
     * Checks is current context has parent
     *
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent !== null;
    }

    /**
     * Returns parent context instance or null if parent context is not exists
     *
     * @return Context|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent for current context
     *
     * @param Context $parent Parent context instance
     *
     * @return void
     */
    public function setParent(Context $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Checks is value or callable is registered under given name in current context or in its parents
     *
     * Returns FALSE if registered value is NULL
     *
     * @param string $name Name of value or callable to check
     *
     * @return bool
     */
    public function has($name)
    {
        $name = (string)$name;
        if ($this->hasValue($name) || $this->hasCallable($name)) {
            return true;
        } else if ($this->hasParent()) {
            return $this->getParent()->has($name);
        } else {
            return false;
        }
    }

}
