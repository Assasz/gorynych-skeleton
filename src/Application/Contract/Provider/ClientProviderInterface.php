<?php

declare(strict_types=1);

namespace App\Application\Contract\Provider;

use App\Domain\Entity\Client;

interface ClientProviderInterface extends ProviderInterface
{
    /**
     * Returns Client entity object by given identifier or NULL if client does not exist
     *
     * @param int $id
     * @return Client|null
     */
    public function fetchOne(int $id): ?Client;
}
