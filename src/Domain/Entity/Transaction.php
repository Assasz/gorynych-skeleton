<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema()
 */
class Transaction
{
    /**
     * @OA\Property(
     *     type="string",
     *     example="XYZ",
     *     readOnly=true
     * )
     */
    private string $id;

    /**
     * @OA\Property(
     *     type="string",
     *     example="Purchase 123"
     * )
     */
    private string $title;

    /**
     * @OA\Property(
     *     type="object",
     *     ref="#/components/schemas/Client",
     * )
     */
    private Client $client;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
