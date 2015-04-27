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

/**
 * Class Assets
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class Assets implements AssetsInterface
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
     *
     */
    const WEIGHT_LOW = 0;
    /**
     *
     */
    const WEIGHT_NORMAL = 1000;
    /**
     *
     */
    const WEIGHT_HIGH = 2000;
    /**
     *
     */
    const WEIGHT_DEFAULT = self::WEIGHT_NORMAL;
    /**
     *
     */
    const KEY_SRC = 'src';
    /**
     *
     */
    const KEY_ATTRIBUTES = 'attributes';
    /**
     *
     */
    const KEY_WEIGHT = 'weight';

    /**
     * @var array
     */
    protected static $allowedScriptPositions = [self::SCRIPT_POSITION_HEAD, self::SCRIPT_POSITION_BODY];

    /**
     * @var array
     */
    private $styleSheets = [];
    /**
     * @var array
     */
    private $scripts = [
        self::SCRIPT_POSITION_HEAD => [],
        self::SCRIPT_POSITION_BODY => []
    ];

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function getStyleSheets($sort = true)
    {
        if ($sort) {
            return $this->sortByWeight($this->styleSheets);
        } else {
            return $this->styleSheets;
        }
    }

    /**
     * @param array $elements
     *
     * @return array
     */
    protected function sortByWeight(array $elements)
    {
        uasort($elements, function ($left, $right) {
            if ($left[static::KEY_WEIGHT] == $right[static::KEY_WEIGHT]) {
                return 0;
            }
            return ($left[static::KEY_WEIGHT] < $right[static::KEY_WEIGHT]) ? -1 : 1;
        });
        return $elements;
    }

    /**
     * @param string $position
     * @param bool   $sort
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function getScripts($position, $sort = true)
    {
        $this->assertScriptPositionExists($position);
        if ($sort) {
            return $this->sortByWeight($this->scripts[$position]);
        } else {
            return $this->scripts[$position];
        }
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
     * @param AssetsInterface $otherAssets
     *
     * @return void
     */
    public function merge(AssetsInterface $otherAssets)
    {
        $this->mergeStyleSheets($otherAssets);
        foreach (static::$allowedScriptPositions as $position) {
            $this->mergeScripts($position, $otherAssets);
        }
    }

    /**
     * @param AssetsInterface $otherAssets
     *
     * @return void
     */
    protected function mergeStyleSheets(AssetsInterface $otherAssets)
    {
        foreach ($otherAssets->getStyleSheets(false) as $styleSheet) {
            $this->addStyleSheet($styleSheet['attributes'], $styleSheet['weight']);
        }
    }

    /**
     * @param string $src
     * @param array  $attributes
     * @param int    $weight
     *
     * @return $this
     */
    public function addStyleSheet($src, array $attributes = [], $weight = self::WEIGHT_DEFAULT)
    {
        $this->styleSheets[$this->cleanAssetSrc($src)] = $this->formatAsset($attributes, $weight);
        return $this;
    }

    /**
     * @param string $src
     *
     * @return string
     */
    protected function cleanAssetSrc($src)
    {
        return trim($src);
    }

    /**
     * @param array  $attributes
     * @param int    $weight
     *
     * @return array
     */
    protected function formatAsset(array $attributes, $weight)
    {
        return [
            self::KEY_ATTRIBUTES => $attributes,
            self::KEY_WEIGHT     => $weight,
        ];
    }

    /**
     * @param string          $position
     * @param AssetsInterface $otherAssets
     *
     * @return void
     */
    protected function mergeScripts($position, AssetsInterface $otherAssets)
    {
        foreach ($otherAssets->getScripts($position, false) as $script) {
            $this->addScript($position, $script['attributes'], $script['weight']);
        }
    }

    /**
     * @param string $position
     * @param string $src
     * @param array  $attributes
     * @param int    $weight
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addScript($position, $src, array $attributes = [], $weight = self::WEIGHT_DEFAULT)
    {
        $this->assertScriptPositionExists($position);
        $this->scripts[$position][$this->cleanAssetSrc($src)] = $this->formatAsset($attributes, $weight);
        return $this;
    }

}
