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
 * Interface AssetsInterface
 *
 * @package Banana\BodyBuilder\Widget
 * @author  Vasily Oksak <voksak@gmail.com>
 */
interface AssetsInterface
{
    /**
     * @param string $src
     * @param array  $attributes
     * @param int    $weight
     *
     * @return $this
     */
    public function addStyleSheet($src, array $attributes = [], $weight = 0);

    /**
     * @param bool $sort
     *
     * @return array
     */
    public function getStyleSheets($sort = true);

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
    public function addScript($position, $src, array $attributes = [], $weight = 0);

    /**
     * @param string $position
     * @param bool   $sort
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function getScripts($position, $sort = true);

    /**
     * @param AssetsInterface $otherAssets
     *
     * @return void
     */
    public function merge(AssetsInterface $otherAssets);

}
