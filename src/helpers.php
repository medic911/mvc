<?php

use Medic911\MVC\App;
use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Contracts\ViewContract;
use Medic911\MVC\Core\Http\Request;
use Medic911\MVC\Core\Router;
use Medic911\MVC\Core\View;

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
     * @return RequestContract
     */
    function request(): RequestContract
    {
        return Request::getInstance();
    }
}

if (!function_exists('view')) {
    /**
     * @param string $templateName
     * @param array $vars
     * @return ViewContract
     */
    function view(string $templateName, array $vars = []): ViewContract
    {
        return new View($templateName, $vars);
    }
}
