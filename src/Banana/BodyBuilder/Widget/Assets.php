<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Widget;

use Banana\BodyBuilder\Elements;

/**
 * Class Assets
 *
 * @todo    Add class description
 * @todo    Add tests
 * @todo    Add priority argument support for ss and js
 * @todo    Check is ss or js already added
 * @todo    Add support of if statements
 *
 * @package BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Assets
{

    use Elements\FactoryTrait;

    const SCRIPT_POSITION_HEAD = 'head';
    const SCRIPT_POSITION_BODY = 'body';

    protected static $allowedScriptPositions = [self::SCRIPT_POSITION_HEAD, self::SCRIPT_POSITION_BODY];

    protected $styleSheetElements = [];
    protected $scriptElements = [
        self::SCRIPT_POSITION_HEAD => [],
        self::SCRIPT_POSITION_BODY => []
    ];

    public function addStyleSheet(array $attributes = [])
    {
        return $this->addStyleSheetElement($this->createElement(Elements\Type::LINK, $attributes));
    }

    public function addStyleSheetElement(Elements\ElementInterface $element)
    {
        $this->styleSheetElements = $element;
        return $this;
    }

    public function addScript($position, array $attributes = [], $content = '')
    {
        return $this->addScriptElement($position, $this->createElement(Elements\Type::SCRIPT, $attributes, $content));
    }

    public function addScriptElement($position, Elements\ElementInterface $element)
    {
        $this->assertScriptPositionExists($position);
        $this->scriptElements[$position][] = $element;
        return $this;
    }

    protected function assertScriptPositionExists($position)
    {
        if (!in_array($position, self::$allowedScriptPositions)) {
            throw new \InvalidArgumentException("Position `$position` for scripts includes is not exists");
        }
    }

    public function merge(Assets $otherAssets)
    {
        foreach ($otherAssets->getStyleSheetElements() as $element) {
            $this->addStyleSheetElement($element);
        }
        foreach (self::$allowedScriptPositions as $position) {
            foreach ($otherAssets->getScriptElements($position) as $element) {
                $this->addScriptElement($position, $element);
            }
        }
    }

    public function getStyleSheetElements()
    {
        return $this->styleSheetElements;
    }

    public function getScriptElements($position)
    {
        $this->assertScriptPositionExists($position);
        return $this->scriptElements[$position];
    }

}
