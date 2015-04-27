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
 * Class Factory
 *
 * @package Banana\BodyBuilder\Elements
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Factory implements FactoryInterface
{

    /**
     * @var array
     */
    protected $classes = [
        ElementAbstract::TYPE_LINK   => Element\Head\Link::class,
        ElementAbstract::TYPE_META   => Element\Head\Meta::class,
        ElementAbstract::TYPE_TITLE  => Element\Head\Title::class,
        ElementAbstract::TYPE_SCRIPT => Element\Script::class,
    ];

    /**
     * @param string $type
     * @param array  $attributes
     * @param string $content
     *
     * @return ElementInterface
     */
    public function createElement($type, array $attributes = [], $content = '')
    {
        $this->assertElementClassExists($type);
        $className = $this->getElementClass($type);
        /** @var ElementInterface $element */
        $element = new $className();
        $element->setAttributes($attributes);
        $element->setContent($content);

        return $element;
    }

    /**
     * @param string $type
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function assertElementClassExists($type)
    {
        if (!$this->hasElementClass($type)) {
            throw new \InvalidArgumentException('Factory has no registered classes for building element with type ' . $type);
        }
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasElementClass($type)
    {
        return isset($this->classes[$type]);
    }

    /**
     * @param string $type
     *
     * @return null|string
     */
    public function getElementClass($type)
    {
        if ($this->hasElementClass($type)) {
            return $this->classes[$type];
        }
        return null;
    }

    /**
     * @param string $type
     * @param string $class
     *
     * @return $this
     */
    public function setElementClass($type, $class)
    {
        $this->assertElementClassCorrect($class);
        $this->classes[$type] = $class;
        return $this;
    }

    /**
     * @param string $class
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function assertElementClassCorrect($class)
    {
        if (in_array(ElementInterface::class, class_implements($class))) {
            throw new \InvalidArgumentException('Element ' . $class . ' must implements ' . ElementInterface::class);
        }
    }

}
