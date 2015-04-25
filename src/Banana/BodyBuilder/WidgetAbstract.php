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
 * Class Widget
 *
 * @todo    Add description of class
 * @todo    Add assets
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class WidgetAbstract
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
     * @return Widget\Assets
     */
    public function getAssets()
    {
        if ($this->assets === null) {
            $this->assets = new Widget\Assets();
        }
        return $this->assets;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Layout
     *
     * @throws \RuntimeException If no templateName file or templateName string specified as widget templateName
     */
    public function getLayout()
    {
        $layout = $this->createLayout();
        $this->buildLayout($layout);
        return $layout;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Layout
     */
    protected function createLayout()
    {
        return new Rendering\Layout($this->getTemplateName());
    }

    /**
     * @return string
     */
    abstract public function getTemplateName();

    /**
     * @param \Banana\BodyBuilder\Rendering\Layout $layout
     *
     * @return void
     */
    protected function buildLayout(Rendering\Layout $layout)
    {
        $this->buildBlock($layout->getBlock());
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Block $block
     *
     * @return void
     */
    abstract protected function buildBlock(Rendering\Block $block);

    /**
     * @param Widget\Assets $otherAssets
     *
     * @return void
     */
    protected function mergeAssets(Widget\Assets $otherAssets)
    {
        if ($this->assets === null) {
            $this->assets = $otherAssets;
        } else {
            $otherAssets->merge($this->assets);
            $this->assets = $otherAssets;
        }
    }
}
