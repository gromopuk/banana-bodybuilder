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
 * Trait FactoryTrait
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Elements
 * @author  Vasily Oksak <voksak@gmail.com>
 */
trait FactoryTrait
{

    /**
     * @var FactoryInterface
     */
    protected $elementsFactory;

    /**
     * @param string $type
     * @param array  $attributes
     * @param string $content
     *
     * @return ElementInterface
     */
    public function createElement($type, array $attributes = [], $content = '')
    {
        return $this->getElementsFactory()->createElement($type, $attributes, $content);
    }

    /**
     * @return FactoryInterface
     */
    public function getElementsFactory()
    {
        if ($this->elementsFactory === null) {
            $this->elementsFactory = new Factory();
        }
        return $this->elementsFactory;
    }

    /**
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function setElementsFactory(FactoryInterface $factory)
    {
        $this->elementsFactory = $factory;
        return $this;
    }

}
