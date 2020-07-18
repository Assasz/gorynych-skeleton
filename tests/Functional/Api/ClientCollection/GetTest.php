<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\ClientCollection;

use App\Domain\Entity\Client;
use Gorynych\Testing\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['clients.yaml']);
    }

    public function testStructure(): void
    {
        static::$client->request(Request::METHOD_GET, self::ENDPOINT_URI);

        $this->assertStatusCodeSame(Response::HTTP_OK);
        $this->assertMatchesCollectionJsonSchema(Client::class);
    }
}
