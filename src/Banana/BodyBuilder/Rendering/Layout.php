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

use Banana\BodyBuilder;

/**
 * Class Layout
 *
 * @todo    Add class description
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Layout implements LayoutInterface
{

    /** @var Block */
    protected $_block;
    /** @var string */
    protected $templateName;
    /** @var Layout[] */
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
     * @return array
     */
    public function getVariables()
    {
        return $this->getBlock()->toArray();
    }

    /**
     * @return Block
     */
    public function getBlock()
    {
        if ($this->_block === null) {
            $this->_block = new BodyBuilder\Rendering\Block();
        }
        return $this->_block;
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
