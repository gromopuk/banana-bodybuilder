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

use Banana\BodyBuilder\Elements\FactoryInterface;
use Banana\BodyBuilder\Widget\AssetsInterface;
use Banana\BodyBuilder\Widget\ContextInterface;

/**
 * Interface WidgetInterface
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface WidgetInterface
{

    /**
     * @param AssetsInterface $assets
     *
     * @return $this
     */
    public function setAssets(AssetsInterface $assets);

    /**
     * @return AssetsInterface
     */
    public function getAssets();

    /**
     * @param ContextInterface $context
     *
     * @return $this
     */
    public function setContext(ContextInterface $context);

    /**
     * @return ContextInterface
     */
    public function getContext();

    /**
     * @return \Banana\BodyBuilder\Rendering\Structure\LayoutInterface
     */
    public function getLayout();

    /**
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function setElementsFactory(FactoryInterface $factory);

    /**
     * @return FactoryInterface
     */
    public function getElementsFactory();

}
