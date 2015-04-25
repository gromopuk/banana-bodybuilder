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


interface LayoutInterface
{

    /**
     * @return string
     */
    public function getTemplateName();

    /**
     * @return array
     */
    public function getVariables();

    /**
     * @return LayoutInterface[]
     */
    public function getIncludedLayouts();

}