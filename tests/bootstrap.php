<?php

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Banana\\', __DIR__.'/../src/Banana');

date_default_timezone_set('UTC');

define('BANANA_BODYBUILDER_TEST_TEMPLATES_PATH', __DIR__);

use Banana\BodyBuilder;

class TestWidgetAbstract extends BodyBuilder\WidgetAbstract
{
    public function getTemplateString()
    {
        return 'Template string';
    }

    protected function buildBlock(BodyBuilder\Rendering\Block $block)
    {
    }
}

class TestWidgetsGroupAbstract extends BodyBuilder\WidgetsGroupAbstract
{
    public function getTemplateString()
    {
        return 'Template string';
    }

    protected function buildBlock(BodyBuilder\Rendering\Block $block)
    {
    }
}