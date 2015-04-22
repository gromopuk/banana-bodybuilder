<?php

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Banana\\', __DIR__.'/../src/Banana');

date_default_timezone_set('UTC');

use Banana\BodyBuilder;

class TestWidget extends BodyBuilder\Widget
{
    public function getTemplateString()
    {
        return 'Template string';
    }

    public function build(BodyBuilder\Widget\Block $block)
    {
    }
}

class TestWidgetsGroup extends BodyBuilder\WidgetsGroup
{
    public function build(\Banana\BodyBuilder\Widget\Block $block)
    {
    }
}