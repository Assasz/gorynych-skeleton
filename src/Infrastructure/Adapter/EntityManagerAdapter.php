<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Application\Contract\Persister\PersisterInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Gorynych\Adapter\EntityManagerAdapterInterface;
use Gorynych\Util\EnvAccess;
use Nelmio\Alice\Loader\NativeLoader;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;

final class EntityManagerAdapter implements EntityManagerAdapterInterface, PersisterInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $this->setup();
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function createSchema(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        (new SchemaTool($this->entityManager))->createSchema($metadata);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function dropSchema(): void
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        (new SchemaTool($this->entityManager))->dropSchema($metadata);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function replace(object $entity): void
    {
        $this->entityManager->merge($entity);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     * @throws \Nelmio\Alice\Throwable\LoadingThrowable
     */
    public function loadFixtures(array $files): int
    {
        $files = array_map(
            static function (string $fileName): string {
                return EnvAccess::get('PROJECT_DIR') . '/config/fixtures/' . $fileName;
            },
            $files
        );

        $fixtures = (new NativeLoader())->loadFiles($files)->getObjects();

        foreach ($fixtures as $fixture) {
            $this->entityManager->persist($fixture);
        }

        $this->entityManager->flush();

        return count($fixtures);
    }

    public function getManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    private function setup(): void
    {
        $entityNamespace = 'App\Domain\Entity';
        $mappingPath = EnvAccess::get('PROJECT_DIR') . '/config/orm';

        $driver = new SimplifiedYamlDriver([$mappingPath => $entityNamespace]);

        $config = Setup::createConfiguration();
        $config->setMetadataDriverImpl($driver);
        $config->addEntityNamespace('Entity', $entityNamespace);
        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        $connection = DriverManager::getConnection(['url' => EnvAccess::get('DATABASE_URL')], $config);
        $this->entityManager = EntityManager::create($connection, $config);
    }
}
