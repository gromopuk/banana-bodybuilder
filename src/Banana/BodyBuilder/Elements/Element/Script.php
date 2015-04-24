<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Elements\Element;

use Banana\BodyBuilder\Elements\ElementAbstract;

/**
 * Class Script
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Elements\Element
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Script extends ElementAbstract
{

    const ASYNC = 'async';
    const DEFER = 'defer';
    const LANGUAGE = 'language';
    const SRC = 'src';
    const TYPE = 'type';

    /**
     * @return string[]
     */
    public static function getElementAttributes()
    {
        return [self::ASYNC, self::DEFER, self::LANGUAGE, self::SRC, self::TYPE];
    }

    /**
     * @return string
     */
    public static function getElementTemplate()
    {
        return '<script ' . self::MARKER_ATTRIBUTES . '>' . self::MARKER_CONTENT . '</script>';
    }

}
