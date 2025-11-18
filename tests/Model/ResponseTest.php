<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Tests\Model;

use PHPUnit\Framework\TestCase;
use Spyck\ApiExtension\Model\Response;
use Spyck\ApiExtension\Model\ConfigInterface;
use Spyck\ApiExtension\Model\Pagination;

final class ResponseTest extends TestCase
{
    public function testConfig(): void
    {
        $response = new Response();

        $this->assertNull($response->getConfig());

        $config = $this->createMock(ConfigInterface::class);

        $response->setConfig($config);

        $this->assertSame($config, $response->getConfig());
    }

    public function testData(): void
    {
        $data = ['a', 'b', 'c'];

        $response = new Response();
        $response->setData($data);

        $this->assertSame($data, $response->getData());
    }

    public function testTotal(): void
    {
        $response = new Response();
        $response->setTotal(24);

        $this->assertSame(24, $response->getTotal());
    }

    public function testPagination(): void
    {
        $response = new Response();

        $this->assertNull($response->getPagination());

        $pagination = new Pagination();
        $response->setPagination($pagination);

        $this->assertSame($pagination, $response->getPagination());
    }
}
