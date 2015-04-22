<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Widget;

use Banana\BodyBuilder;
use Banana\BodyBuilder\Widget\Block;
use Banana\BodyBuilder\Rendering\Template\Type as TemplateType;
use Banana\BodyBuilder\Rendering\LayoutInterface;

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
    private $_block;
    /** @var string */
    private $_template;
    /** @var string */
    private $_templateType;
    /** @var Layout[] */
    private $_includes = [];

    /**
     * @param string $filePath
     *
     * @return Layout
     */
    public static function createFromFile($filePath)
    {
        return new static(TemplateType::FILE, $filePath);
    }

    /**
     * @param string $templateString
     *
     * @return Layout
     */
    public static function createFromString($templateString)
    {
        return new static(TemplateType::STRING, $templateString);
    }

    /**
     * @param string $type
     * @param string $template
     *
     * @throws \InvalidArgumentException If given template type is not supported
     */
    public function __construct($type, $template)
    {
        $this->setTemplate($type, $template);
    }

    /**
     * @param string $type
     * @param string $template
     *
     * @return void
     *
     * @throws \InvalidArgumentException If given template type is not supported
     */
    protected function setTemplate($type, $template)
    {
        try {
            TemplateType::assertExists($type);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Template type `$type` is not supported", 0, $e);
        }

        $this->_templateType = $type;
        $this->_template = (string)$template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * @return string
     */
    public function getTemplateType()
    {
        return $this->_templateType;
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
            $this->_block = new BodyBuilder\Widget\Block();
        }
        return $this->_block;
    }

    /**
     * @param string $name
     * @param Layout $layout
     *
     * @return void
     */
    public function includeLayout($name, Layout $layout)
    {
        $this->_includes[(string)$name] = $layout;
    }

    /**
     * @return Layout[]
     */
    public function getIncludedLayouts()
    {
        return $this->_includes;
    }

}
