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

/**
 * Abstract class WidgetAbstract
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class WidgetAbstract implements WidgetInterface
{

    use Elements\FactoryTrait;

    /**
     * @var Widget\Context|null
     */
    protected $context;
    /**
     * @var Widget\Assets|null
     */
    protected $assets;

    /**
     * @return Widget\Assets|null
     */
    public function getAssets()
    {
        if ($this->assets === null) {
            $this->assets = new Widget\Assets();
        }
        return $this->assets;
    }

    /**
     * @param Widget\Assets $assets
     *
     * @return $this
     */
    public function setAssets(Widget\Assets $assets)
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
     * @return Widget\Context
     */
    public function getContext()
    {
        if ($this->context === null) {
            $this->context = new Widget\Context();
        }
        return $this->context;
    }

    /**
     * @param Widget\Context $context
     *
     * @return $this
     */
    public function setContext(Widget\Context $context)
    {
        $this->getContext()->setParent($context);
        return $this;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Structure\LayoutInterface
     */
    public function getLayout()
    {
        $layout = $this->createLayout();
        $this->buildLayout($layout);
        return $layout;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Structure\LayoutInterface
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
     * @param \Banana\BodyBuilder\Rendering\Structure\LayoutInterface $layout
     *
     * @return void
     */
    protected function buildLayout(Rendering\Structure\LayoutInterface $layout)
    {
        $this->buildBlock($layout->getBlock());
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Structure\Block $block
     *
     * @return void
     */
    abstract protected function buildBlock(Rendering\Structure\Block $block);

}
