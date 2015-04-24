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
 * Interface FactoryInterface
 *
 * @package Banana\BodyBuilder\Elements
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface FactoryInterface
{

    /**
     * @param string $type
     * @param array  $attributes
     * @param string $content
     *
     * @return ElementInterface
     */
    public function createElement($type, array $attributes = [], $content = '');

}
