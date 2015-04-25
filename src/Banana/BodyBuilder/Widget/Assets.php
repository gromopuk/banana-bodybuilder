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

use Banana\BodyBuilder\Elements\ElementInterface;

/**
 * Class Assets
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Assets
{

    /**
     *
     */
    const SCRIPT_POSITION_HEAD = 'head';
    /**
     *
     */
    const SCRIPT_POSITION_BODY = 'body';

    /**
     * @var array
     */
    protected static $allowedScriptPositions = [self::SCRIPT_POSITION_HEAD, self::SCRIPT_POSITION_BODY];

    /**
     * @var ElementInterface[]
     */
    protected $styleSheetElements = [];
    /**
     * @var array
     */
    protected $scriptElements = [
        self::SCRIPT_POSITION_HEAD => [],
        self::SCRIPT_POSITION_BODY => []
    ];

    /**
     * @param Assets $otherAssets
     *
     * @return void
     */
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

    /**
     * @return ElementInterface[]
     */
    public function getStyleSheetElements()
    {
        return $this->styleSheetElements;
    }

    /**
     * @param ElementInterface $element
     *
     * @return $this
     */
    public function addStyleSheetElement(ElementInterface $element)
    {
        $this->styleSheetElements[] = $element;
        return $this;
    }

    /**
     * @param string $position
     *
     * @return ElementInterface[]
     *
     * @throws \InvalidArgumentException
     */
    public function getScriptElements($position)
    {
        $this->assertScriptPositionExists($position);
        return $this->scriptElements[$position];
    }

    /**
     * @param string $position
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function assertScriptPositionExists($position)
    {
        if (!in_array($position, self::$allowedScriptPositions)) {
            throw new \InvalidArgumentException('Position `' . $position . '` for scripts includes is not exists');
        }
    }

    /**
     * @param string           $position
     * @param ElementInterface $element
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addScriptElement($position, ElementInterface $element)
    {
        $this->assertScriptPositionExists($position);
        $this->scriptElements[$position][] = $element;
        return $this;
    }

}
