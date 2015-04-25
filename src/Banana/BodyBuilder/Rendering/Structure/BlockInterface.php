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
 * Interface BlockInterface
 *
 * @package Banana\BodyBuilder\Rendering\Structure
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface BlockInterface
{

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setVariable($name, $value);

    /**
     * @param string              $name
     * @param BlockInterface|null $block
     *
     * @return BlockInterface
     */
    public function addBlock($name, BlockInterface $block = null);

    /**
     * @return array
     */
    public function getVariables();

    /**
     * @return array
     */
    public function getBlocks();

}
