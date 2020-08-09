<?php

declare(strict_types=1);

namespace App\Application\Resource\Client;

use App\Application\Contract\Persister\PersistenceAwareTrait;
use App\Application\Contract\Provider\ClientProviderInterface;
use App\Domain\Entity\Client;
use Gorynych\Http\Exception\NotFoundHttpException;
use Gorynych\Http\Exception\UnprocessableEntityHttpException;
use Gorynych\Resource\AbstractResource;
use Gorynych\Resource\ResourceInterface;

class ClientResource extends AbstractResource implements ResourceInterface
{
    use PersistenceAwareTrait;

    public const PATH_PATTERN = '/clients/%s';

    private ClientProviderInterface $clientProvider;

    public function __construct(ClientProviderInterface $clientProvider)
    {
        $this->clientProvider = $clientProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
         return sprintf(self::PATH_PATTERN, $this->id ?? self::NUMERIC_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($item): bool
    {
        return $item instanceof Client;
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundHttpException
     */
    public function retrieve(): Client
    {
        $client = $this->clientProvider->fetchOne((int)$this->id);

        if (false === $this->supports($client)) {
            throw new NotFoundHttpException();
        }

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        $this->persister->remove($this->retrieve());
        $this->save();
    }

    /**
     * {@inheritdoc}
     * @throws UnprocessableEntityHttpException
     */
    public function replace($item): string
    {
        if (false === $this->supports($item)) {
            throw new UnprocessableEntityHttpException();
        }

        /** @var Client $item */
        $item->setId((int)$this->id);

        $this->persister->replace($item);
        $this->save();

        return $this->getPath();
    }

    /**
     * {@inheritdoc}
     */
    public function save(): void
    {
        $this->persister->flush();
    }
}
