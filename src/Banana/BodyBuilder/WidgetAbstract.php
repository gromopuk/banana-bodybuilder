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

use Banana\BodyBuilder\Elements;
use Banana\BodyBuilder\Widget;
use Banana\BodyBuilder\Widget\AssetsInterface;
use Banana\BodyBuilder\Widget\ContextInterface;

/**
 * Abstract class WidgetAbstract
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class WidgetAbstract implements WidgetInterface
{

    /**
     * @var ContextInterface|null
     */
    protected $context;
    /**
     * @var AssetsInterface|null
     */
    protected $assets;
    /**
     * @var Elements\FactoryInterface
     */
    protected $elementsFactory;

    /**
     * @return AssetsInterface
     */
    public function getAssets()
    {
        if ($this->assets === null) {
            $this->assets = new Widget\Assets();
        }
        return $this->assets;
    }

    /**
     * @param AssetsInterface $assets
     *
     * @return $this
     */
    public function setAssets(AssetsInterface $assets)
    {
        if ($this->assets === null) {
            $this->assets = $assets;
        } else {
            $assets->merge($this->assets);
            $this->assets = $assets;
        }
        return $this;
    }

    /**
     * @return ContextInterface
     */
    public function getContext()
    {
        if ($this->context === null) {
            $this->context = new Widget\Context();
        }
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     *
     * @return $this
     */
    public function setContext(ContextInterface $context)
    {
        $this->getContext()->setParent($context);
        return $this;
    }

    /**
     * @return Rendering\Structure\Layout
     */
    public function getLayout()
    {
        $layout = $this->createLayout();
        $this->buildLayout($layout);
        return $layout;
    }

    /**
     * @return Rendering\Structure\Layout
     */
    protected function createLayout()
    {
        return new Rendering\Structure\Layout($this->getTemplateName());
    }

    /**
     * @return string
     */
    abstract protected function getTemplateName();

    /**
     * @param Rendering\Structure\LayoutInterface $layout
     *
     * @return void
     */
    protected function buildLayout(Rendering\Structure\LayoutInterface $layout)
    {
        $this->buildBlock($layout->getBlock());
    }

    /**
     * @param Rendering\Structure\BlockInterface $block
     *
     * @return void
     */
    abstract protected function buildBlock(Rendering\Structure\BlockInterface $block);

    /**
     * @return Elements\FactoryInterface
     */
    public function getElementsFactory()
    {
        if ($this->elementsFactory === null) {
            $this->elementsFactory = new Elements\Factory();
        }
        return $this->elementsFactory;
    }

    /**
     * @param Elements\FactoryInterface $factory
     *
     * @return $this
     */
    public function setElementsFactory(Elements\FactoryInterface $factory)
    {
        $this->elementsFactory = $factory;
        return $this;
    }

}
