<?php

namespace Tests\Core;

use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;
use Medic911\MVC\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var RouterContract
     */
    protected RouterContract $router;

    /**
     * RouterTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->router = new Router;
    }

    /**
     * @test
     * @throws NotFoundRouteException
     */
    public function testMatchRoute(): void
    {
        $this->router->addRoute('/exist-path', function() {});
        $this->assertIsCallable($this->router->match('/exist-path'));
    }

    /**
     * @test
     */
    public function testNotMatchRoute(): void
    {
        $this->expectException(NotFoundRouteException::class);

        $this->router->match('/bad-path');
    }
}