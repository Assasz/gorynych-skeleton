<?php

declare(strict_types=1);

namespace App\Application\Contract\Provider;

use App\Domain\Entity\Transaction;

interface TransactionProviderInterface extends ProviderInterface
{
    public function fetchOne(string $id): ?Transaction;


    /**
     * @return Transaction[]
     */
    public function fetchByClient(int $clientId): array;
}
