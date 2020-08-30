<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api\Transaction;

use App\Domain\Entity\Transaction;
use Gorynych\Testing\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTest extends ApiTestCase
{
    private const ENDPOINT_URI = '/transactions/ABC1';

    public function setUp(): void
    {
        parent::setUp();

        static::$entityManager->loadFixtures(['transactions.yaml']);
    }

    public function testStructure(): void
    {
        static::$client->request(Request::METHOD_GET, self::ENDPOINT_URI);

        $this->assertStatusCodeSame(Response::HTTP_OK);
        $this->assertMatchesItemJsonSchema(Transaction::class);
    }
}
