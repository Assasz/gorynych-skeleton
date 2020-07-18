<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\ClientCollection;

use App\Domain\Entity\Client;
use Gorynych\Generator\EntityMock;
use Gorynych\Http\KernelClient;
use Gorynych\Testing\ApiTestCase;
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
                KernelClient::JSON_BODY => (array)$entityMock
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
                KernelClient::JSON_BODY => (array)$entityMock
            ]
        );

        static::$client->request(Request::METHOD_GET, static::normalizeResponse()['@id']);

        $responseBody = static::normalizeResponse();
        array_shift($responseBody);

        $this->assertMatchesItemJsonSchema(Client::class);
        $this->assertSame((array)$entityMock, $responseBody);
    }
}
