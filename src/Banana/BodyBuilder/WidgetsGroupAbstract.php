<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder;

/**
 * Abstract class WidgetsGroupAbstract
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class WidgetsGroupAbstract extends WidgetAbstract
{

    /** @var WidgetInterface[] */
    protected $widgets = [];

    /**
     * @param string $position
     * @param WidgetInterface $widget
     *
     * @return $this
     */
    public function addWidget($position, WidgetInterface $widget)
    {
        $this->widgets[$position] = $widget;
        $widget->setContext($this->getContext())
            ->setAssets($this->getAssets())
            ->setElementsFactory($this->getElementsFactory());
        return $this;
    }

    /**
     * @param string $position
     *
     * @return WidgetInterface|null
     */
    public function getWidget($position)
    {
        if ($this->hasWidget($position)) {
            return $this->widgets[(string)$position];
        }
        return null;
    }

    /**
     * @param string $position
     *
     * @return bool
     */
    public function hasWidget($position)
    {
        return isset($this->widgets[(string)$position]);
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Structure\LayoutInterface $layout
     *
     * @return void
     */
    protected function buildLayout(Rendering\Structure\LayoutInterface $layout)
    {
        parent::buildLayout($layout);
        foreach ($this->getWidgets() as $position => $widget) {
            $layout->includeLayout($position, $widget->getLayout());
        }
    }

    /**
     * @return WidgetInterface[]
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

}
