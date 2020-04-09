<?php

use Medic911\MVC\App;
use Medic911\MVC\Core\Router;
use Whoops\Handler\PrettyPageHandler;

Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

if (!inProduction()) {
    $whoops = new Whoops\Run;
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}

$app = App::getInstance();
$app->setRouter(new Router);

return $app;