<?php

require(__DIR__ . '/vendor' . '/autoload.php');

use \Slim\App;

require(__DIR__ . '/app' . '/function.php');

$config = [
    'settings' => require(__DIR__ . '/app' . '/config.php'),
];
$app = new App($config);

require(__DIR__ . '/app' . '/dependency.php');
require(__DIR__ . '/app' . '/middleware.php');

require(__DIR__ . '/app' . '/route.php');

$app->run();
