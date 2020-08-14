<?php

use Medic911\MVC\App;
use Medic911\MVC\Core\Contracts\RequestContract;
use Medic911\MVC\Core\Contracts\TemplateContract;
use Medic911\MVC\Core\Http\Request;
use Medic911\MVC\Core\Templates\TwigTemplate;

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
     * @return TemplateContract
     */
    function view(string $templateName, array $vars = []): TemplateContract
    {
        return new TwigTemplate($templateName, $vars);
    }
}
