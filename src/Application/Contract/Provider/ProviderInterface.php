<?php

declare(strict_types=1);

namespace App\Application\Contract\Provider;

interface ProviderInterface
{
    /**
     * Returns whole entity collection
     *
     * @return object[]
     */
    public function fetchAll(): array;

    /**
     * Returns entity collection matching given criteria
     *
     * @param mixed[] $criteria
     * @param string[]|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return object[]
     */
    public function fetchBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array;
}
