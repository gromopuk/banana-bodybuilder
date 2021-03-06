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
use Banana\BodyBuilder\WidgetInterface;

/**
 * Class BodyBuilder
 *
 * @package Banana
 * @author  Vasily Oksak <voksak@gmail.com>
 */
class BodyBuilder
{

    /**
     * @var EngineInterface|null
     */
    protected $renderingEngine;

    /**
     * @param WidgetInterface $widget
     *
     * @return void
     *
     * @throws \RuntimeException If Rendering engine instance is not installed
     */
    public function build(WidgetInterface $widget)
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
            throw new \RuntimeException('Rendering engine is not installed');
        }
    }

    /**
     * @return EngineInterface|null
     */
    public function getRenderingEngine()
    {
        return $this->renderingEngine;
    }

    /**
     * @param EngineInterface $engine
     *
     * @return $this
     */
    public function setRenderingEngine(EngineInterface $engine)
    {
        $this->renderingEngine = $engine;
        return $this;
    }

}
