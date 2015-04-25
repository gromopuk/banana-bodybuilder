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
 * Interface LayoutInterface
 *
 * @package Banana\BodyBuilder\Rendering
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface LayoutInterface
{

    /**
     * @return string
     */
    public function getTemplateName();

    /**
     * @return Block
     */
    public function getBlock();

    /**
     * @param string          $name
     * @param LayoutInterface $layout
     *
     * @return mixed
     */
    public function includeLayout($name, LayoutInterface $layout);

    /**
     * @return LayoutInterface[]
     */
    public function getIncludedLayouts();

}