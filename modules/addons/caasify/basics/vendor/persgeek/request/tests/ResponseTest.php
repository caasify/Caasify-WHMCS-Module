<?php

use PG\Request\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testArray()
    {
        $data = json_encode(['test' => 'test']);

        $response = new Response($data);

        $this->assertArrayHasKey('test', $response->asArray());
    }

    public function testObject()
    {
        $data = json_encode(['test' => 'test']);

        $response = new Response($data);

        $this->assertObjectHasAttribute('test', $response->asObject());
    }
}
