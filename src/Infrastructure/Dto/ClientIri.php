<?php

declare(strict_types=1);

namespace App\Infrastructure\Dto;

use App\Application\Resource\Client\ClientResource;
use App\Domain\Entity\Client;

/**
 * @OA\Schema()
 */
final class ClientIri
{
    /**
     * @OA\Property(
     *     type="string",
     *     example="/clients/1"
     * )
     */
    public string $client;

    public function __construct(Client $client)
    {
        $this->client = sprintf(ClientResource::PATH_PATTERN, $client->getId());
    }
}
