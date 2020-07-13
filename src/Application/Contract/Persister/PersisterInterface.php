<?php

declare(strict_types=1);

namespace App\Application\Contract\Persister;

interface PersisterInterface
{
    /**
     * Persists entity object
     *
     * @param object $entity
     */
    public function persist(object $entity): void;

    /**
     * Removes entity object
     *
     * @param object $entity
     */
    public function remove(object $entity): void;

    /**
     * Merges provided entity object into persistence context
     *
     * @param object $entity
     */
    public function replace(object $entity): void;

    /**
     * Saves changes made to entity objects
     */
    public function flush(): void;
}
