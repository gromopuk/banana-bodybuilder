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

/**
 * Interface ElementInterface
 *
 * @package Banana\BodyBuilder\Elements
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface ElementInterface
{

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes);

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function toString();

}
