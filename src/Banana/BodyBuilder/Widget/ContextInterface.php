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
 * Interface ContextInterface
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface ContextInterface
{
    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function set($name, $value);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function get($name);

    /**
     * Set parent for current context
     *
     * @param ContextInterface $parent Parent context instance
     *
     * @return void
     */
    public function setParent(ContextInterface $parent);

    /**
     * Checks is current context has parent
     *
     * @return bool
     */
    public function hasParent();

    /**
     * Returns parent context instance or null if parent context is not exists
     *
     * @return ContextInterface|null
     */
    public function getParent();

}
