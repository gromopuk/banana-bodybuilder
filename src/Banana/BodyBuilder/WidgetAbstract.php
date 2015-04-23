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
     * @var Widget\Context
     */
    protected $context;
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
     * @throws \RuntimeException If no template file or template string specified as widget template
     */
    public function getLayout()
    {
        $layout = $this->createLayout();
        $this->buildLayout($layout);
        return $layout;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Layout
     *
     * @throws \RuntimeException If no template file or template string specified as widget template
     */
    protected function createLayout()
    {
        if ($this->hasTemplateFile()) {
            return Rendering\Layout::createFromFile($this->getTemplateFile());
        } else if ($this->hasTemplateString()) {
            return Rendering\Layout::createFromString($this->getTemplateString());
        } else {
            throw new \RuntimeException("Widget has no template file or template string to be used");
        }
    }

    /**
     * @return bool
     */
    public function hasTemplateFile()
    {
        return (bool)$this->getTemplateFile();
    }

    /**
     * @return null|string
     */
    public function getTemplateFile()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function hasTemplateString()
    {
        return (bool)$this->getTemplateString();
    }

    /**
     * @return null|string
     */
    public function getTemplateString()
    {
        return null;
    }

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
