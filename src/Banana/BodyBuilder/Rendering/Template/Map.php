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
 * @todo    Add class description
 *
 * @package Banana\BodyBuilder\Rendering\Template
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Map implements MapInterface
{

    private $_templatesPath;
    private $_extension;

    public function __construct($templatesPath, $extension = null)
    {
        $this->_templatesPath = rtrim($this->fixDirectorySeparator($templatesPath), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->_extension = (string)$extension;
    }

    public function getTemplatesPath()
    {
        return $this->_templatesPath;
    }

    public function getExtension()
    {
        return $this->_extension;
    }

    public function getTemplateFilePath($templateName)
    {
        $templateName = trim($this->fixDirectorySeparator($templateName), DIRECTORY_SEPARATOR);
        return $this->getTemplatesPath() . $templateName . $this->getExtension();
    }

    protected function fixDirectorySeparator($path)
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
    }

}
