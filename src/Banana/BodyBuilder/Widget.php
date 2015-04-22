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
     */
    public function buildLayout()
    {
        $layout = $this->createLayout();
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
     */
    protected function createLayout()
    {
        $templateName = $this->getTemplateFile();
        if ($templateName) {
            return Widget\Layout::createFromFile($templateName);
        } else {
            return Widget\Layout::createFromString($this->getTemplateString());
        }
    }

}
