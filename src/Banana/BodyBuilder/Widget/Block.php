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
 * Class Block
 *
 * @todo    Add class description
 *
 * @package Banana\BodyBuilder\Widget\Layout
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Block
{

    private $_variables = [];
    private $_blocks = [];

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setVariable($name, $value)
    {
        $name = (string)$name;
        if ($this->hasBlock($name)) {
            throw new \InvalidArgumentException("Variable name `$name` already used by one of inner blocks");
        }

        $this->_variables[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     *
     */
    public function hasVariable($name)
    {
        return isset($this->_variables[(string)$name]);
    }

    public function getVariable($name)
    {
        if ($this->hasVariable($name)) {
            return $this->_variables[(string)$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->_variables;
    }

    /**
     * @param string $name
     * @param Block  $block
     *
     * @return Block
     * @throws \InvalidArgumentException
     */
    public function addBlock($name, Block $block = null)
    {
        $name = (string)$name;
        if ($this->hasVariable($name)) {
            throw new \InvalidArgumentException("Block name `$name` already used by one of variables");
        }

        if (!$this->hasBlock($name)) {
            $this->_blocks[$name] = [];
        }

        if ($block === null) {
            $block = new Block();
        }
        $this->_blocks[$name][] = $block;

        return $block;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasBlock($name)
    {
        return isset($this->_blocks[(string)$name]);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function getBlocks($name)
    {
        $name = (string)$name;
        if (isset($this->_blocks[$name])) {
            return $this->_blocks[$name];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAllBlocks()
    {
        return $this->_blocks;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = $this->getVariables();
        foreach ($this->getAllBlocks() as $blockName => $blocks) {
            /** @var Block $block */
            foreach ($blocks as $block) {
                $array[$blockName][] = $block->toArray();
            }
        }

        return $array;
    }

}
