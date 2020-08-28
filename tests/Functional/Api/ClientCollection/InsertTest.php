<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\ClientCollection;

use App\Domain\Entity\Client;
use Gorynych\Http\RequestFactory;
use Gorynych\Testing\ApiTestCase;
use Gorynych\Testing\EntityMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InsertTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['clients.yaml']);
    }

    public function testStructure(): void
    {
        $entityMock = EntityMock::create(Client::class);

        static::$client->request(Request::METHOD_POST, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        $this->assertStatusCodeSame(Response::HTTP_CREATED);
        $this->assertArrayHasKey('@id', static::normalizeResponse());
        $this->assertStringStartsWith(self::ENDPOINT_URI, static::normalizeResponse()['@id']);
    }

    public function testInserted(): void
    {
        $entityMock = EntityMock::create(Client::class);

        static::$client->request(Request::METHOD_POST, self::ENDPOINT_URI, [
                RequestFactory::REQUEST_JSON => (array) $entityMock
            ]
        );

        static::$client->request(Request::METHOD_GET, static::normalizeResponse()['@id']);

        $this->assertMatchesItemJsonSchema(Client::class);
        $this->assertContainsSubset($entityMock);
    }
}
