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
 * Class Widget
 *
 * @todo    Add description of class
 * @todo    Add assets
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class Widget
{

    /**
     * @var Widget\Context
     */
    protected $context;

    /**
     * @return null|string
     */
    public function getTemplateFile()
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getTemplateString()
    {
        return null;
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
     * @return Widget\Layout
     *
     * @throws \RuntimeException If no template file or template string specified as widget template
     * @throws \UnexpectedValueException If method self::createLayout() not returns instance of Banana\BodyBuilder\Widget\Layout
     */
    public function buildLayout()
    {
        $layout = $this->createLayout();
        if (!$layout instanceof Widget\Layout) {
            throw new \UnexpectedValueException('Method ' . get_class($this) . '::createLayout() must return instance of Banana\BodyBuilder\Widget\Layout');
        }
        $this->build($layout->getBlock());
        return $layout;
    }

    /**
     * @param Widget\Block $block
     *
     * @return void
     */
    abstract public function build(Widget\Block $block);

    /**
     * @return Widget\Layout
     *
     * @throws \RuntimeException If no template file or template string specified as widget template
     */
    protected function createLayout()
    {
        if ($this->hasTemplateFile()) {
            return Widget\Layout::createFromFile($this->getTemplateFile());
        } else if ($this->hasTemplateString()) {
            return Widget\Layout::createFromString($this->getTemplateString());
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
     * @return bool
     */
    public function hasTemplateString()
    {
        return (bool)$this->hasTemplateString();
    }
}
