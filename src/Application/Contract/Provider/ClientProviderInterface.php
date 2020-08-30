<?php

declare(strict_types=1);

namespace App\Application\Contract\Provider;

use App\Domain\Entity\Client;

interface ClientProviderInterface extends ProviderInterface
{
    public function fetchOne(int $id): ?Client;
}
