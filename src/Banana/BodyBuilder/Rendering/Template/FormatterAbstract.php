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
 * Abstract class FormatterAbstract
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Rendering\Template
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class FormatterAbstract implements FormatterInterface
{
    const OPEN_MARKER = '';
    const CLOSE_MARKER = '';
    const BLOCK_OPEN_MARKER = '';
    const BLOCK_CLOSE_MARKER = '';
    const INCLUDE_OPEN_MARKER = '';
    const INCLUDE_CLOSE_MARKER = '';
    const VARIABLE_MARKER = '';

    /**
     * @param string $templateString
     *
     * @return string
     */
    public function format($templateString)
    {
        return str_replace($this->getSearchMarkers(), $this->getReplaceMarkers(), $templateString);
    }

    /**
     * @return string[]
     */
    protected function getSearchMarkers()
    {
        return [
            BodyBuilder::BLOCK_CLOSE_MARKER,
            BodyBuilder::BLOCK_OPEN_MARKER,
            BodyBuilder::INCLUDE_CLOSE_MARKER,
            BodyBuilder::INCLUDE_OPEN_MARKER,
            BodyBuilder::CLOSE_MARKER,
            BodyBuilder::VARIABLE_MARKER,
            BodyBuilder::OPEN_MARKER,
        ];
    }

    /**
     * @return string[]
     */
    abstract protected function getReplaceMarkers();

}
