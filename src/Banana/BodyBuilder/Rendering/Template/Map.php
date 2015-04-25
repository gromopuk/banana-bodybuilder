<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Template;

use Banana\BodyBuilder;

/**
 * Class Map
 *
 * @package Banana\BodyBuilder\Rendering\Template
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Map implements MapInterface
{

    /**
     * @var string
     */
    protected $templatesPath;
    /**
     * @var string
     */
    protected $extension;
    /**
     * @var bool
     */
    protected $checkTemplateFiles = true;

    /**
     * @param string $templatesPath
     * @param string $extension
     */
    public function __construct($templatesPath, $extension = '')
    {
        $this->templatesPath = rtrim($this->fixDirectorySeparator($templatesPath),
                DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->extension = (string)$extension;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function fixDirectorySeparator($path)
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
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
     * @param string $templateName
     *
     * @return string
     */
    public function getTemplateFilePath($templateName)
    {
        $templateName = trim($this->fixDirectorySeparator($templateName), DIRECTORY_SEPARATOR);
        $templateFile = $this->getTemplatesPath() . $templateName . $this->getExtension();
        $this->assertTemplateFileExists($templateFile);
        return $templateFile;
    }

    /**
     * @return string
     */
    public function getTemplatesPath()
    {
        return $this->templatesPath;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $templateFile
     *
     * @return void
     */
    protected function assertTemplateFileExists($templateFile)
    {
        if ($this->isCheckTemplateFilesExists() && !file_exists($templateFile)) {
            throw new \RuntimeException('Template file `' . $templateFile . '` not exists');
        }
    }

    /**
     * @return bool
     */
    public function isCheckTemplateFilesExists()
    {
        return $this->checkTemplateFiles;
    }

}
