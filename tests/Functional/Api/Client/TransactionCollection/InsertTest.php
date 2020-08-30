<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\Client\TransactionCollection;

use App\Domain\Entity\Transaction;
use Gorynych\Http\RequestFactory;
use Gorynych\Testing\ApiTestCase;
use Gorynych\Testing\EntityMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InsertTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients/1/transactions';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['transactions.yaml']);
    }

    public function testStructure(): void
    {
        $entityMock = EntityMock::create(Transaction::class);

        static::$client->request(Request::METHOD_POST, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        $this->assertStatusCodeSame(Response::HTTP_CREATED);
        $this->assertArrayHasKey('@id', static::normalizeResponse());
        $this->assertStringStartsWith('/transactions', static::normalizeResponse()['@id']);
    }

    public function testInserted(): void
    {
        $entityMock = EntityMock::create(Transaction::class);

        static::$client->request(Request::METHOD_POST, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        static::$client->request(Request::METHOD_GET, static::normalizeResponse()['@id']);

        $this->assertMatchesItemJsonSchema(Transaction::class);
        $this->assertContainsSubset($entityMock);
    }
}
