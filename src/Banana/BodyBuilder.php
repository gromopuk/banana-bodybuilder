<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana;

use Banana\BodyBuilder\Widget;
use Banana\BodyBuilder\Rendering\EngineInterface;

/**
 * Class BodyBuilder
 *
 * @todo    Add class description
 *
 * @package Banana
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class BodyBuilder
{

    /**
     * @var \Banana\BodyBuilder\Rendering\EngineInterface|null
     */
    private $_renderingEngine;

    /**
     * @param \Banana\BodyBuilder\Rendering\EngineInterface $engine
     *
     * @return self
     */
    public function setRenderingEngine(EngineInterface $engine)
    {
        $this->_renderingEngine = $engine;

        return $this;
    }

    /**
     * @return \Banana\BodyBuilder\Rendering\EngineInterface
     */
    public function getRenderingEngine()
    {
        return $this->_renderingEngine;
    }

    /**
     * @param Widget $widget
     *
     * @return void
     *
     * @throws \RuntimeException If Rendering engine instance is not installed
     */
    public function build(Widget $widget)
    {
        $this->assertRenderingEngineInstalled();
        $this->getRenderingEngine()->render($widget->buildLayout());
    }

    /**
     * @return void
     *
     * @throws \RuntimeException
     */
    public function assertRenderingEngineInstalled()
    {
        if (!$this->getRenderingEngine()) {
            throw new \RuntimeException("Rendering engine is not installed");
        }
    }
}