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

/**
 * Interface MapInterface
 *
 * @package Banana\BodyBuilder\Rendering\Template
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface MapInterface
{

    /**
     * @param string $templateName
     *
     * @return string
     */
    public function getTemplateFilePath($templateName);

}
