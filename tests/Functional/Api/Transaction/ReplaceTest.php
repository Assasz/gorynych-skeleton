<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\Transaction;

use App\Domain\Entity\Transaction;
use Gorynych\Http\RequestFactory;
use Gorynych\Testing\ApiTestCase;
use Gorynych\Testing\EntityMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplaceTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/transactions/ABC1';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['transactions.yaml']);
    }

    public function testStructure(): void
    {
        $entityMock = EntityMock::create(Transaction::class);

        static::$client->request(Request::METHOD_PUT, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        $this->assertStatusCodeSame(Response::HTTP_OK);
        $this->assertArrayHasKey('@id', static::normalizeResponse());
        $this->assertSame(self::ENDPOINT_URI, static::normalizeResponse()['@id']);
    }

    public function testReplaced(): void
    {
        $entityMock = EntityMock::create(Transaction::class);

        static::$client->request(Request::METHOD_PUT, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        static::$client->request(Request::METHOD_GET, self::ENDPOINT_URI);

        $this->assertMatchesItemJsonSchema(Transaction::class);
        $this->assertContainsSubset($entityMock);
    }
}
