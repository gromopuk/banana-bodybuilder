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
use Banana\BodyBuilder\Rendering\EngineInterface;
use Banana\BodyBuilder\Rendering\LayoutInterface;
use Banana\BodyBuilder\Rendering\Template;
use Banana\BodyBuilder\Rendering\Template\FormatterInterface;
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
class Blitz implements EngineInterface
{

    private static $_driverStatus;

    protected $stringTemplateFormatter;
    protected $templateMap;
    protected $includeTemplateFileVariable = 'template';
    protected $includeBlockNamePrefix = 'include_';

    /**
     * @param \Banana\BodyBuilder\Rendering\Template\MapInterface $templateMap
     */
    public function __construct(Template\MapInterface $templateMap)
    {
        $this->templateMap = $templateMap;
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
            $engine = new \Blitz($this->getTemplateMap()->getTemplateFilePath($layout->getTemplate()));
        } else {
            $engine = (new \Blitz)->load($this->getStringTemplateFormatter()->format($layout->getTemplate()));
        }

        return $engine;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Template\MapInterface
     */
    public function getTemplateMap()
    {
        return $this->templateMap;
    }

    /**
     * @return FormatterInterface
     */
    public function getStringTemplateFormatter()
    {
        if ($this->stringTemplateFormatter === null) {
            $this->stringTemplateFormatter = new Blitz\Template\Formatter();
        }
        return $this->stringTemplateFormatter;
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
         * @var string          $includeName
         * @var LayoutInterface $includeLayout
         */
        foreach ($layout->getIncludedLayouts() as $includeName => $includeLayout) {
            /** @todo add support of string templates rendering through inner render() call and replace by additional variable in block instead template variable */
            if ($includeLayout->getTemplateType() != TemplateType::FILE) {
                throw new \InvalidArgumentException("Blitz engine can include only files, string includes are not supported");
            }

            $includeParameters = $this->buildParameters($includeLayout);
            $this->assertReservedVariablesNamesNotUsed($includeParameters);

            $includeParameters[$this->getIncludeTemplateFileVariable()] = $this->getTemplateMap()->getTemplateFilePath($includeLayout->getTemplate());
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

    public function getIncludeTemplateFileVariable()
    {
        return $this->includeTemplateFileVariable;
    }

    public function setIncludeTemplateFileVariable($name)
    {
        $this->includeTemplateFileVariable = (string)$name;

        return $this;
    }

    public function getIncludeBlockNamePrefix()
    {
        return $this->includeBlockNamePrefix;
    }

    public function setIncludeBlockNamePrefix($prefix)
    {
        $this->includeBlockNamePrefix = (string)$prefix;

        return $this;
    }

    /**
     * @param LayoutInterface $layout
     *
     * @return string
     */
    public function fetch(LayoutInterface $layout)
    {
        // TODO: Implement fetch() method.
    }

}
