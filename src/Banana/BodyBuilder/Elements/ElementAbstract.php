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

    const ATTRIBUTES_MARKER = '@attributes';
    const CONTENT_MARKER = '@content';

    protected $attributes = [];
    protected $content = '';

    public function init(array $attributes, $content = null)
    {
        $this->setAttributes($attributes);
        $this->setContent($content);
    }

    public function setAttribute($name, $value)
    {
        $name = (string)$name;
        $this->assertElementAttributesExists([$name => $value]);
        $this->attributes[$name] = $value;
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
        if ($wrongAttributes) {
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

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->assertElementAttributesExists($attributes);
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    public function toString()
    {
        $search = [static::ATTRIBUTES_MARKER, static::CONTENT_MARKER];
        $replace = [$this->getAttributesAsString(), $this->getContent()];
        return str_replace($search, $replace, static::getElementTemplate());
    }

    public function getAttributesAsString()
    {
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = (string)$content;
    }

    public static function getElementTemplate()
    {
        return "";
    }

}
