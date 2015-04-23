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

trait FactoryTrait
{

    protected $elementsFactory;

    public function createElement($type, array $attributes = [], $content = '')
    {
        return $this->getElementsFactory()->createElement($type, $attributes, $content);
    }

    public function getElementsFactory()
    {
        if ($this->elementsFactory === null) {
            $this->elementsFactory = new Factory();
        }
        return $this->elementsFactory;
    }

    public function setElementsFactory(FactoryInterface $factory)
    {
        $this->elementsFactory = $factory;
    }

}
