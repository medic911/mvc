<?php

namespace Tests\Core\Http;

use Medic911\MVC\Core\Http\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 * @package Core\Http
 */
class ResponseTest extends TestCase
{

    /**
     * @test
     */
    public function testResponse():void
    {
        $response = new Response;
        $response->withBody('Body')
            ->withStatus(404)
            ->withContentType('text/html')
            ->withHeader('X-Header', '');

        $this->assertEquals('Body', $response->getBody());
        $this->assertEquals(404, $response->getStatus());
        $this->assertEquals('text/html', $response->getContentType());
        $this->assertArrayHasKey('X-Header', $response->getHeaders());
    }

    /**
     * @test
     */
    public function testMakeJsonResponse(): void
    {
        $data = ['name' => 'value'];
        $response = Response::json($data);

        $this->assertEquals(json_encode($data), $response->getBody());
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('text/plain', $response->getContentType());
    }

    /**
     * @test
     */
    public function testMake404Response(): void
    {
        $response = Response::e404();

        $this->assertEquals(404, $response->getStatus());
    }
}