<?php

use PG\Request\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testAddress()
    {
        $request = new Request();

        $request->setAddress('test');

        $this->assertSame('test', $request->getAddress());
    }

    public function testMergeAddress()
    {
        $request = new Request();

        $request->setAddress(['test/test']);

        $this->assertSame('test/test', $request->mergeAddress());
    }

    public function testHeaders()
    {
        $request = new Request();

        $request->setHeaders(['test' => 'test']);

        $this->assertArrayHasKey('test', $request->getHeaders());
    }

    public function testMergeHeaders()
    {
        $request = new Request();

        $request->setHeaders(['test' => 'test']);

        $this->assertContains('test:test', $request->mergeHeaders());
    }

    public function testParams()
    {
        $request = new Request();

        $request->setParams(['test' => 'test']);

        $this->assertArrayHasKey('test', $request->getParams());
    }

    public function testMergeParams()
    {
        $request = new Request();

        $request->setParams(['test' => 'test']);

        $this->assertSame('test=test', $request->mergeParams());
    }
}
