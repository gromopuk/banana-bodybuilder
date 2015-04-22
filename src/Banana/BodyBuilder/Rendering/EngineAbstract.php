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

use Banana\BodyBuilder\Rendering\Template;

abstract class EngineAbstract implements EngineInterface
{

    /** @var \Banana\BodyBuilder\Rendering\Template\MapInterface  */
    private $_templateMap;
    /**
     * @var bool
     */
    protected $checkTemplateFiles = true;

    /**
     * @param \Banana\BodyBuilder\Rendering\Template\MapInterface $templateMap
     */
    public function __construct(Template\MapInterface $templateMap)
    {
        $this->_templateMap = $templateMap;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\Template\MapInterface
     */
    public function getTemplateMap()
    {
        return $this->_templateMap;
    }

    /**
     * @param bool $flag
     *
     * @return $this
     */
    public function setCheckTemplateFilesExists($flag)
    {
        $this->checkTemplateFiles = (bool)$flag;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCheckTemplateFilesExists()
    {
        return $this->checkTemplateFiles;
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

    /**
     * @param string $templateName
     *
     * @return mixed
     *
     * @throws \RuntimeException If template file is not exists
     */
    protected function getTemplateFilePath($templateName)
    {
        $templateFilePath = $this->getTemplateMap()->getTemplateFilePath($templateName);
        if ($this->isCheckTemplateFilesExists()) {
            $this->assertTemplateFileExists($templateFilePath);
        }
        return $templateFilePath;
    }

    /**
     * @param $templateFilePath
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function assertTemplateFileExists($templateFilePath)
    {
        if (!file_exists($templateFilePath)) {
            throw new \RuntimeException("Template file path `$templateFilePath` is not exists");
        }
    }

}
