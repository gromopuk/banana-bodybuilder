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


class Factory implements FactoryInterface
{

    protected $classes = [
        Type::LINK   => Element\Head\Link::class,
        Type::META   => Element\Head\Meta::class,
        Type::TITLE  => Element\Head\Title::class,
        Type::SCRIPT => Element\Script::class,
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

    protected function assertElementClassExists($type)
    {
        if (!$this->hasElementClass($type)) {
            throw new \InvalidArgumentException('Factory has no registered classes for building element with type ' . $type);
        }
    }

    public function hasElementClass($type)
    {
        return isset($this->classes[$type]);
    }

    public function getElementClass($type)
    {
        if ($this->hasElementClass($type)) {
            return $this->classes[$type];
        }
        return null;
    }

    public function setElementClass($type, $class)
    {
        $this->assertElementClassCorrect($class);
        $this->classes[$type] = $class;
        return $this;
    }

    protected function assertElementClassCorrect($class)
    {
        if (in_array(ElementInterface::class, class_implements($class))) {
            throw new \InvalidArgumentException('Element ' . $class . ' must implements ' . ElementInterface::class);
        }
    }
}