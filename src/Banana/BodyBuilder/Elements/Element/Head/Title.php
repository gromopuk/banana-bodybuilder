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
 * Class Title
 *
 * @package Banana\BodyBuilder\Elements\Element\Head
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Title extends ElementAbstract
{

    /**
     * @param string $title
     */
    public function __construct($title = '')
    {
        $this->setContent($title);
    }

    /**
     * @return string
     */
    public static function getElementTemplate()
    {
        return '<title>' . self::MARKER_CONTENT . '</title>';
    }

}
