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
        Type::LINK   => Head\Link::class,
        Type::SCRIPT => Script::class,
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
        $element->init($attributes, $content);

        return $element;
    }

    protected function assertElementClassExists($type)
    {
        if (!$this->hasElementClass($type)) {
            throw new \InvalidArgumentException("Factory has no registered classes for building element with type `$type`");
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
    }

    protected function assertElementClassCorrect($class)
    {
        if (false) {
            throw new \InvalidArgumentException("Element class `$class` must implements " . ElementInterface::class);
        }
    }
}