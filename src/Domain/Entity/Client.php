<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\Collection;

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

    /**
     * @var Transaction[]|Collection<int, Transaction>
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Transaction"),
     * )
     */
    private Collection $transactions;

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

    /**
     * @return Transaction[]|Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $transaction->setClient($this);
        $this->transactions->add($transaction);
    }
}
