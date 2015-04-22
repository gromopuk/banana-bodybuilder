<?php

/*
 * This file is part of the Banana framework.
 *
 * (c) Vasily Oksak <voksak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Banana\BodyBuilder\Rendering\Engine;

use Banana\BodyBuilder\Rendering\EngineAbstract;
use Banana\BodyBuilder\Rendering\LayoutInterface;
use Banana\BodyBuilder\Rendering\Template\Type as TemplateType;

class Native extends EngineAbstract
{

    /**
     * @param LayoutInterface $layout
     *
     * @return void
     */
    public function render(LayoutInterface $layout)
    {
        extract($layout->getVariables());
        if ($layout->getTemplateType() == TemplateType::STRING) {
            echo $layout->getTemplate();
        } else {
            include $this->getTemplateFilePath($layout->getTemplate());
        }
    }
}