<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder;

/**
 * Interface WidgetInterface
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface WidgetInterface
{

    /**
     * @param Widget\Assets $assets
     *
     * @return $this
     */
    public function setAssets(Widget\Assets $assets);

    /**
     * @return Widget\Assets
     */
    public function getAssets();

    /**
     * @param Widget\Context $context
     *
     * @return $this
     */
    public function setContext(Widget\Context $context);

    /**
     * @return Widget\Context
     */
    public function getContext();

    /**
     * @return \Banana\BodyBuilder\Rendering\Structure\LayoutInterface
     */
    public function getLayout();

}