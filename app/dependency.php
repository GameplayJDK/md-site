<?php

use \Parsedown as Markdown;

use \Mustache_Engine as Template;

$container = $app->getContainer();

$container['config'] = function ($container)
{

    return $container->settings;
};

$container['converter'] = function ($container)
{

    return new Markdown();
};

$container['renderer'] = function ($container)
{

    return new Template();
};
