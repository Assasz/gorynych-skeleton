<?php

declare(strict_types=1);

namespace App\Application\Contract\Persister;

trait PersistenceAwareTrait
{
    private PersisterInterface $persister;

    /**
     * @required
     */
    public function setPersister(PersisterInterface $persister): void
    {
        $this->persister = $persister;
    }
}
