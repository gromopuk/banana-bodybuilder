<?php

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Banana\\', __DIR__.'/../src/Banana');

date_default_timezone_set('UTC');