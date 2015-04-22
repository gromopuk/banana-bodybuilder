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

use Banana\BodyBuilder\Rendering\LayoutInterface;

interface EngineInterface
{

    /**
     * @param LayoutInterface $layout
     *
     * @return void
     */
    public function render(LayoutInterface $layout);

    /**
     * @param LayoutInterface $layout
     *
     * @return string
     */
    public function fetch(LayoutInterface $layout);

}