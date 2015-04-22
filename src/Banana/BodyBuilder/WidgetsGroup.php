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
abstract class WidgetsGroup extends Widget
{

    /** @var Widget[] */
    protected $widgets = [];

    /**
     * @return Widget[]
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    public function setWidget($position, Widget $widget)
    {
        $this->widgets[$position] = $widget;
        $widget->getContext()->setParent($this->getContext());
        /** @todo Add assets merge */

        return $widget;
    }

    public function hasWidget($position)
    {
        return isset($this->widgets[$position]);
    }

    public function getWidget($position)
    {
        if ($this->hasWidget($position)) {
            return $this->widgets[$position];
        }
        return null;
    }

    /**
     * @param Widget\Layout $layout
     *
     * @return void
     */
    protected function buildLayout(Widget\Layout $layout)
    {
        parent::buildLayout($layout);
        foreach ($this->getWidgets() as $position => $widget) {
            $layout->includeLayout($position, $widget->getLayout());
        }
    }
}