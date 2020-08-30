<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Contract\Provider\TransactionProviderInterface;
use App\Domain\Entity\Transaction;
use App\Infrastructure\Adapter\EntityManagerAdapter;

/**
 * @method find($id, $lockMode = null, $lockVersion = null): ?Transaction
 */
final class TransactionRepository extends AbstractEntityRepository implements TransactionProviderInterface
{
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct($managerAdapter, Transaction::class);
    }

    public function fetchOne(string $id): ?Transaction
    {
        return $this->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchByClient(int $clientId): array
    {
        return $this->findBy(['client' => $clientId]);
    }
}
