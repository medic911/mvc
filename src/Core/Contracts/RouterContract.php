<?php

namespace Medic911\MVC\Core\Contracts;

use Closure;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;

/**
 * Interface RouterContract
 * @package Medic911\MVC\Core\Contracts
 */
interface RouterContract
{
    /**
     * @param string $path
     * @param Closure $callback
     */
    public function addRoute(string $path, Closure $callback): void;

    /**
     * @param string $path
     * @return Closure
     * @throws NotFoundRouteException
     */
    public function match(string $path): Closure;
}