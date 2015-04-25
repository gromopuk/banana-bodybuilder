<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Elements\Element\Head;

use Banana\BodyBuilder\Elements\ElementAbstract;

/**
 * Class Link
 *
 * @package Banana\BodyBuilder\Elements\Element\Head
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Link extends ElementAbstract
{

    const CHARSET = 'charset';
    const HREF = 'href';
    const MEDIA = 'media';
    const REL = 'rel';
    const SIZES = 'sizes';
    const TYPE = 'type';

    /**
     * @return string[]
     */
    public static function getElementAttributes()
    {
        return [self::CHARSET, self::HREF, self::MEDIA, self::REL, self::SIZES, self::TYPE];
    }

    /**
     * @return string
     */
    public static function getElementTemplate()
    {
        return '<link ' . self::MARKER_ATTRIBUTES . '>';
    }

}
