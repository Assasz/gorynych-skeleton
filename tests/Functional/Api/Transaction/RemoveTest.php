<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\Transaction;

use Gorynych\Testing\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/transactions/ABC1';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['transactions.yaml']);
    }

    public function testStructure(): void
    {
        static::$client->request(Request::METHOD_DELETE, self::ENDPOINT_URI);

        $this->assertStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testRemoved(): void
    {
        static::$client->request(Request::METHOD_DELETE, self::ENDPOINT_URI);
        static::$client->request(Request::METHOD_GET, self::ENDPOINT_URI);

        $this->assertStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
