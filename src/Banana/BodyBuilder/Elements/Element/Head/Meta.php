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
 * Class Meta
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Elements\Element\Head
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Meta extends ElementAbstract
{
    const CHARSET = 'charset';
    const NAME = 'name';
    const HTTP_EQUIV = 'http-equiv';
    const CONTENT = 'content';

    /**
     * @return string[]
     */
    public static function getElementAttributes()
    {
        return [self::CHARSET, self::NAME, self::HTTP_EQUIV, self::CONTENT];
    }

    /**
     * @return string
     */
    public static function getElementTemplate()
    {
        return '<meta ' . self::MARKER_ATTRIBUTES . '>';
    }

}
