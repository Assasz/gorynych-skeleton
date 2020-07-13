<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Contract\Provider\ClientProviderInterface;
use App\Domain\Entity\Client;
use App\Infrastructure\Adapter\EntityManagerAdapter;

/**
 * @method find($id, $lockMode = null, $lockVersion = null): ?Client
 */
class ClientRepository extends AbstractEntityRepository implements ClientProviderInterface
{
    public function __construct(EntityManagerAdapter $managerAdapter)
    {
        parent::__construct($managerAdapter, Client::class);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne(int $id): ?Client
    {
        return $this->find($id);
    }
}
