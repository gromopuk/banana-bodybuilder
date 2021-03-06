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

use Banana\BodyBuilder\Rendering\Structure\LayoutInterface;

/**
 * Interface EngineInterface
 *
 * @package Banana\BodyBuilder\Rendering
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface EngineInterface
{

    /**
     * @param \Banana\BodyBuilder\Rendering\Template\MapInterface $templateMap
     */
    public function __construct(Template\MapInterface $templateMap);

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
