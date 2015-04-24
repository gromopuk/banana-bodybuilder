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
 * Abstract class ElementAbstract
 *
 * @todo    Add class description
 * @todo    Add tests
 *
 * @package Banana\BodyBuilder\Elements
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class ElementAbstract implements ElementInterface
{

    /**
     *
     */
    const MARKER_ATTRIBUTES = '@attributes';

    /**
     *
     */
    const MARKER_CONTENT = '@content';

    /**
     * @var array
     */
    protected $attributes = [];
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param string      $name
     * @param string|bool $value
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setAttribute($name, $value)
    {
        $name = (string)$name;
        $this->assertElementAttributesExists([$name => $value]);
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function assertElementAttributesExists(array $attributes)
    {
        $wrongAttributes = array_diff($attributes, array_flip(static::getElementAttributes()));
        if (!empty($wrongAttributes)) {
            throw new \InvalidArgumentException('Element ' . get_class($this) . ' is not supporting attributes: ' . implode(', ',
                    $wrongAttributes));
        }
    }

    /**
     * @return string[]
     */
    public static function getElementAttributes()
    {
        return [];
    }

    /**
     * @param string $name
     *
     * @return null|string|bool
     */
    public function getAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            return $this->attributes[(string)$name];
        }
        return null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasAttribute($name)
    {
        return isset($this->attributes[(string)$name]);
    }

    /**
     * @return string
     */
    public function toString()
    {
        $search = [static::MARKER_ATTRIBUTES, static::MARKER_CONTENT];
        $replace = [$this->getAttributesAsString(), $this->getContent()];
        return str_replace($search, $replace, static::getElementTemplate());
    }

    /**
     * @return string
     */
    public function getAttributesAsString()
    {
        if ($this->hasAttributes()) {
            $attributes = [];
            foreach ($this->attributes as $attributeName => $attributeValue) {
                $attribute = $attributeName;
                if (!is_bool($attributeValue)) {
                    $attribute .= '="' . $attributeValue . '"';
                }
                $attributes[] = $attribute;
            }
            return implode(' ', $attributes);
        }
        return '';
    }

    /**
     * @return bool
     */
    public function hasAttributes()
    {
        return (bool)$this->getAttributes();
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setAttributes(array $attributes)
    {
        if (!empty($attributes)) {
            $this->assertElementAttributesExists($attributes);
            $this->attributes = array_merge($this->attributes, $attributes);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = (string)$content;
        return $this;
    }

    /**
     * @return string
     */
    public static function getElementTemplate()
    {
        return '';
    }

}
