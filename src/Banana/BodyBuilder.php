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

use Banana\BodyBuilder\Rendering\EngineInterface;
use Banana\BodyBuilder\WidgetAbstract;

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
     * @param WidgetAbstract $widget
     *
     * @return void
     *
     * @throws \RuntimeException If Rendering engine instance is not installed
     */
    public function build(WidgetAbstract $widget)
    {
        $this->assertRenderingEngineInstalled();
        $this->getRenderingEngine()->render($widget->getLayout());
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

    /**
     * @return \Banana\BodyBuilder\Rendering\EngineInterface
     */
    public function getRenderingEngine()
    {
        return $this->_renderingEngine;
    }

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
}