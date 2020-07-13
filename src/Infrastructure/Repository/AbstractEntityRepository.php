<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Contract\Provider\ProviderInterface;
use App\Infrastructure\Adapter\EntityManagerAdapter;
use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityRepository extends EntityRepository implements ProviderInterface
{
    public function __construct(EntityManagerAdapter $managerAdapter, string $entityClass)
    {
        $manager = $managerAdapter->getManager();

        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(): array
    {
        return $this->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }
}
