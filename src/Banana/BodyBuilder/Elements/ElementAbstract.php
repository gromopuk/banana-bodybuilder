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

abstract class ElementAbstract implements ElementInterface
{

    const MARKER_ATTRIBUTES = '@attributes';
    const MARKER_CONTENT = '@content';

    protected $attributes = [];
    protected $content = '';

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

    public static function getElementAttributes()
    {
        return [];
    }

    public function getAttribute($name)
    {
        if ($this->hasAttribute($name)) {
            return $this->attributes[(string)$name];
        }
        return null;
    }

    public function hasAttribute($name)
    {
        return isset($this->attributes[(string)$name]);
    }

    public function toString()
    {
        $search = [static::MARKER_ATTRIBUTES, static::MARKER_CONTENT];
        $replace = [$this->getAttributesAsString(), $this->getContent()];
        return str_replace($search, $replace, static::getElementTemplate());
    }

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

    public function hasAttributes()
    {
        return (bool)$this->getAttributes();
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        if (!empty($attributes)) {
            $this->assertElementAttributesExists($attributes);
            $this->attributes = array_merge($this->attributes, $attributes);
        }
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = (string)$content;
        return $this;
    }

    public static function getElementTemplate()
    {
        return '';
    }

}
