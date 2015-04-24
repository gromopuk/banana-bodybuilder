<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Engine\Blitz\Template;

use Banana\BodyBuilder\Rendering\Template\FormatterAbstract;

class Formatter extends FormatterAbstract
{

    const OPEN_MARKER = '{{ ';
    const CLOSE_MARKER = ' }}';
    const BLOCK_OPEN_MARKER = '{{ BEGIN';
    const BLOCK_CLOSE_MARKER = '{{ END';
    const INCLUDE_OPEN_MARKER = '{{ include(';
    const INCLUDE_CLOSE_MARKER = ') }}';
    const VARIABLE_MARKER = '$';

    /**
     * @return string[]
     */
    protected function getReplaceMarkers()
    {
        return [
            self::BLOCK_CLOSE_MARKER,
            self::BLOCK_OPEN_MARKER,
            self::INCLUDE_CLOSE_MARKER,
            self::INCLUDE_OPEN_MARKER,
            self::CLOSE_MARKER,
            self::VARIABLE_MARKER,
            self::OPEN_MARKER,
        ];
    }
}