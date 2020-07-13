<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\ClientCollection;

use App\Domain\Entity\Client;
use Gorynych\Testing\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/clients';

    public function setUp(): void
    {
        parent::setUp();

        $this->entityManager->loadFixtures(['clients.yaml']);
    }

    public function testStructure(): void
    {
        $response = $this->client->request('GET', self::ENDPOINT_URI);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertMatchesCollectionJsonSchema($response, Client::class);
    }
}
