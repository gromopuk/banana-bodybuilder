<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Elements;


class Script extends ElementAbstract
{

    const ASYNC = 'async';
    const DEFER = 'defer';
    const LANGUAGE = 'language';
    const SRC = 'src';
    const TYPE = 'type';

    public static function getElementAttributes()
    {
        return [self::ASYNC, self::DEFER, self::LANGUAGE, self::SRC, self::TYPE];
    }

    public static function getElementTemplate()
    {
        return '<script ' . self::ATTRIBUTES_MARKER . '>' . self::CONTENT_MARKER . '</script>';
    }

}