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
 * Class Group
 *
 * @todo    Add class description
 *
 * @package Banana\BodyBuilder
 * @author  Vasily Oksak <voksak@gmail.com>
 */
abstract class WidgetsGroupAbstract extends WidgetAbstract
{

    /** @var WidgetAbstract[] */
    protected $widgets = [];

    public function addWidget($position, WidgetAbstract $widget)
    {
        $this->widgets[$position] = $widget;
        $widget->getContext()->setParent($this->getContext());
        $widget->mergeAssets($this->getAssets());
        $widget->setElementsFactory($this->getElementsFactory());

        return $this;
    }

    public function getWidget($position)
    {
        if ($this->hasWidget($position)) {
            return $this->widgets[$position];
        }
        return null;
    }

    public function hasWidget($position)
    {
        return isset($this->widgets[$position]);
    }

    /**
     * @param \Banana\BodyBuilder\Rendering\Layout $layout
     *
     * @return void
     */
    protected function buildLayout(Rendering\Layout $layout)
    {
        parent::buildLayout($layout);
        foreach ($this->getWidgets() as $position => $widget) {
            $layout->includeLayout($position, $widget->getLayout());
        }
    }

    /**
     * @return WidgetAbstract[]
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

}
