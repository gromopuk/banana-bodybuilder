<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Structure;

/**
 * Class Block
 *
 * @package Banana\BodyBuilder\Rendering
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Block implements BlockInterface
{

    /**
     * @var array
     */
    protected $variables = [];
    /**
     * @var BlockInterface[]
     */
    protected $blocks = [];

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setVariable($name, $value)
    {
        $name = (string)$name;
        if ($this->hasBlock($name)) {
            throw new \InvalidArgumentException('Variable name `' . $name . '` already used by one of inner blocks');
        }

        $this->variables[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasBlock($name)
    {
        return isset($this->blocks[(string)$name]);
    }

    /**
     * @param string $name
     *
     * @return null
     */
    public function getVariable($name)
    {
        if ($this->hasVariable($name)) {
            return $this->variables[(string)$name];
        }
        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasVariable($name)
    {
        return isset($this->variables[(string)$name]);
    }

    /**
     * @param string $name
     * @param BlockInterface|null $block
     *
     * @return Block
     * @throws \InvalidArgumentException
     */
    public function addBlock($name, BlockInterface $block = null)
    {
        $name = (string)$name;
        if ($this->hasVariable($name)) {
            throw new \InvalidArgumentException('Block name `' . $name . '` already used by one of variables');
        }

        if (!$this->hasBlock($name)) {
            $this->blocks[$name] = [];
        }

        if ($block === null) {
            $block = new Block();
        }
        $this->blocks[$name][] = $block;

        return $block;
    }

    /**
     * @param string $name
     *
     * @return BlockInterface[]
     */
    public function getBlocksByName($name)
    {
        $name = (string)$name;
        if (isset($this->blocks[$name])) {
            return $this->blocks[$name];
        }

        return [];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = $this->getVariables();
        foreach ($this->getBlocks() as $blockName => $blocks) {
            /** @var Block[] $blocks */
            foreach ($blocks as $block) {
                $array[$blockName][] = $block->toArray();
            }
        }

        return $array;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @return array
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

}
