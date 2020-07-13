<?php

declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema()
 */
class Client
{
    /**
     * @OA\Property(
     *     type="integer",
     *     example="1",
     *     readOnly=true
     * )
     */
    private int $id;

    /**
     * @OA\Property(
     *     type="string",
     *     example="John"
     * )
     */
    private string $firstname;

    /**
     * @OA\Property(
     *     type="string",
     *     example="Doe"
     * )
     */
    private string $lastname;

    /**
     * @OA\Property(
     *     type="string",
     *     example="john@doe.com"
     * )
     */
    private string $email;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Client
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): Client
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): Client
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Client
    {
        $this->email = $email;

        return $this;
    }
}
