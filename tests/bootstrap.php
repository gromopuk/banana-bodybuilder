<?php

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Banana\\', __DIR__.'/../src/Banana');

date_default_timezone_set('UTC');

define('BANANA_BODYBUILDER_TEST_TEMPLATES_PATH', __DIR__);

use Banana\BodyBuilder;

class TestWidget extends BodyBuilder\Widget
{
    public function getTemplateString()
    {
        return 'Template string';
    }

    protected function buildBlock(BodyBuilder\Widget\Block $block)
    {
    }
}

class TestWidgetsGroup extends BodyBuilder\WidgetsGroup
{
    public function getTemplateString()
    {
        return 'Template string';
    }
    protected function buildBlock(\Banana\BodyBuilder\Widget\Block $block)
    {
    }
}