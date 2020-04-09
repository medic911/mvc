<?php

use Medic911\MVC\App;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Http\Request;
use Medic911\MVC\Core\Router;

if (!function_exists('inProduction')) {
    /**
     * @return bool
     */
    function inProduction(): bool
    {
        $appEnv = getenv('APP_ENV');

        return $appEnv === 'PROD' || $appEnv === 'PRODUCTION';
    }
}

if (!function_exists('app')) {
    /**
     * @return App
     */
    function app(): App
    {
        return App::getInstance();
    }
}

if (!function_exists('request')) {
    /**
     * @return Request
     */
    function request(): Request
    {
        return Request::getInstance();
    }
}
