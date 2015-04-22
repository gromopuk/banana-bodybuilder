<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Engine;

use Banana\BodyBuilder;
use Banana\BodyBuilder\Rendering\EngineAbstract;
use Banana\BodyBuilder\Rendering\Template;
use Banana\BodyBuilder\Rendering\LayoutInterface;
use Banana\BodyBuilder\Rendering\Template\Type as TemplateType;

/**
 * Class Renderer
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Renderer\Blitz
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Blitz extends EngineAbstract
{

    private static $_driverStatus;

    private $_includeTemplateFileVariable = 'template';
    private $_includeBlockNamePrefix = 'include_';


    public function setIncludeTemplateFileVariable($name)
    {
        $this->_includeTemplateFileVariable = (string)$name;

        return $this;
    }

    public function getIncludeTemplateFileVariable()
    {
        return $this->_includeTemplateFileVariable;
    }

    public function setIncludeBlockNamePrefix($prefix)
    {
        $this->_includeBlockNamePrefix = (string)$prefix;

        return $this;
    }

    public function getIncludeBlockNamePrefix()
    {
        return $this->_includeBlockNamePrefix;
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\LayoutInterface $layout
     *
     * @return void
     *
     * @throws \RuntimeException If blitz extension is not installed or loaded
     * @throws \InvalidArgumentException If given structure contents include with string template. Blitz engine can
     *                                   include only files so string includes are not supported
     */
    public function render(LayoutInterface $layout)
    {
        $this->assertExtensionLoaded();
        $this->prepareEngine($layout)
            ->display($this->buildParameters($layout));
    }

    /**
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function assertExtensionLoaded()
    {
        if (self::$_driverStatus === null) {
            if (extension_loaded('blitz')) {
                self::$_driverStatus = true;
            } else {
                throw new \RuntimeException("Extension `blitz` required for rendering templates with Blitz template engine");
            }
        }
    }

    /**
     * @param LayoutInterface $layout
     *
     * @return \Blitz
     */
    protected function prepareEngine(LayoutInterface $layout)
    {
        if ($layout->getTemplateType() == BodyBuilder\Rendering\Template\Type::FILE) {
            $engine = new \Blitz($this->getTemplateFilePath($layout->getTemplate()));
        } else {
            $engine = (new \Blitz)->load($layout->getTemplate());
        }

        return $engine;
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\LayoutInterface $layout
     *
     * @return array
     */
    protected function buildParameters(LayoutInterface $layout)
    {
        $parameters = $layout->getVariables();
        /**
         * @var string             $includeName
         * @var LayoutInterface $includeLayout
         */
        foreach ($layout->getIncludedLayouts() as $includeName => $includeLayout) {
            /** @todo add support of string templates rendering through inner render() call and replace by additional variable in block instead template variable */
            if ($includeLayout->getTemplateType() != TemplateType::FILE) {
                throw new \InvalidArgumentException("Blitz engine can include only files, string includes are not supported");
            }

            $includeParameters = $this->buildParameters($includeLayout);
            $this->assertReservedVariablesNamesNotUsed($includeParameters);

            $includeParameters[$this->getIncludeTemplateFileVariable()] = $this->getTemplateFilePath($includeLayout->getTemplate());
            $includeBlockName = $this->getIncludeBlockNamePrefix() . $includeName;
            $parameters[$includeBlockName] = $includeParameters;
        }

        return $parameters;
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    protected function assertReservedVariablesNamesNotUsed(array $parameters)
    {
        if (isset($parameters[$this->getIncludeTemplateFileVariable()])) {
            throw new \UnexpectedValueException("Variable name `" . $this->getIncludeTemplateFileVariable() . "` for template file path of included " .
                "structure is already used by inner structure variable or block");
        }
    }
}
