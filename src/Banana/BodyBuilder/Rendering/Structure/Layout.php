<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Structure;

use Banana\BodyBuilder;

/**
 * Class Layout
 *
 * @package Banana\BodyBuilder\Rendering
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Layout implements LayoutInterface
{

    /** @var BlockInterface */
    protected $block;
    /** @var string */
    protected $templateName;
    /** @var LayoutInterface[] */
    protected $includes = [];

    /**
     * @param string $templateName
     */
    public function __construct($templateName)
    {
        $this->setTemplateName($templateName);
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     *
     * @return void
     */
    protected function setTemplateName($templateName)
    {
        $this->templateName = (string)$templateName;
    }

    /**
     * @return BlockInterface
     */
    public function getBlock()
    {
        if ($this->block === null) {
            $this->block = new BodyBuilder\Rendering\Structure\Block();
        }
        return $this->block;
    }

    /**
     * @param string $name
     * @param LayoutInterface $layout
     *
     * @return void
     */
    public function includeLayout($name, LayoutInterface $layout)
    {
        $this->includes[(string)$name] = $layout;
    }

    /**
     * @return LayoutInterface[]
     */
    public function getIncludedLayouts()
    {
        return $this->includes;
    }

}
