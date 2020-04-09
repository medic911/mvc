<?php

namespace Tests\Core\Http;

use Medic911\MVC\Core\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 * @package Core\Http
 */
class RequestTest extends TestCase
{
    /**
     * RouterTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    /**
     * @test
     */
    public function testRequest(): void
    {
        $request = Request::getInstance();
        $this->assertEquals('/test', $request->getPath());
        $this->assertEquals('GET', $request->getMethod());
    }
}