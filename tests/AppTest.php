<?php

namespace Tests;

use Medic911\MVC\App;
use Medic911\MVC\Core\Contracts\RouterContract;
use Medic911\MVC\Core\Exceptions\NotFoundRouteException;
use Medic911\MVC\Core\Http\Request;
use Medic911\MVC\Core\Http\Response;
use Medic911\MVC\Core\Router;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * @var MockObject
     */
    protected MockObject $request;

    /**
     * @var MockObject
     */
    protected MockObject $router;

    /**
     * AppTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getPath'])
            ->getMock();
        $this->request->method('getPath')
            ->willReturn('');

        $this->router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['match'])
            ->getMock();
    }

    /**
     * @test
     */
    public function testApp(): void
    {
        $app = App::getInstance();

        $this->router->method('match')
            ->willReturn(function () {return '';});

        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals(200, $response->getStatus());
    }

    /**
     * @test
     */
    public function testMakeResponseAsObject(): void
    {
        $app = App::getInstance();

        $this->router->method('match')
            ->willReturn(function () {
                $response = new Response;
                $response->withBody('Response content');
                return $response;
            });

        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals('Response content', $response->getBody());
    }

    /**
     * @test
     */
    public function testMakeResponseAsString(): void
    {
        $app = App::getInstance();

        $this->router->method('match')
             ->willReturn(function () {return 'Response content';});

        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals('Response content', $response->getBody());
    }

    /**
     * @test
     */
    public function testMakeResponseAsArray(): void
    {
        $app = App::getInstance();

        $this->router->method('match')
            ->willReturn(function () {return ['Response content'];});

        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals(json_encode(['Response content']), $response->getBody());
        $this->assertEquals('text/plain', $response->getContentType());
    }

    /**
     * @test
     */
    public function testNotFoundException(): void
    {
        $app = App::getInstance();

        $this->router->method('match')
            ->willThrowException(new NotFoundRouteException());

        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals(404, $response->getStatus());
    }

    /**
     * @test
     */
    public function testGetRouter(): void
    {
        $app = App::getInstance();
        $app->setRouter($this->router);

        $this->assertInstanceOf(RouterContract::class, $app->getRouter());
    }

    /**
     * @test
     */
    public function testInvalidRouteCallbackReturn(): void
    {
        $this->router->method('match')
            ->willReturn(function () { return null; });

        $app = App::getInstance();
        $app->setRouter($this->router);
        $response = $app->handleRequest($this->request);

        $this->assertEquals(500, $response->getStatus());
    }
}