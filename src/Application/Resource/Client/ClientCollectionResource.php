<?php

declare(strict_types=1);

namespace App\Application\Resource\Client;

use App\Application\Contract\Persister\PersistenceAwareTrait;
use App\Application\Contract\Provider\ClientProviderInterface;
use App\Domain\Entity\Client;
use Cake\Collection\Collection;
use Gorynych\Http\Exception\UnprocessableEntityHttpException;
use Gorynych\Resource\AbstractResource;
use Gorynych\Resource\CollectionResourceInterface;

class ClientCollectionResource extends AbstractResource implements CollectionResourceInterface
{
    use PersistenceAwareTrait;

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
        return '/clients/';
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
     */
    public function retrieve(): Collection
    {
        return new Collection($this->clientProvider->fetchAll());
    }

    /**
     * {@inheritdoc}
     */
    public function remove(): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function replace($item): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * {@inheritdoc}
     * @throws UnprocessableEntityHttpException
     */
    public function insert($item): void
    {
        if (false === $this->supports($item)) {
            throw new UnprocessableEntityHttpException();
        }

        $this->persister->persist($item);
        $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public function save(): void
    {
        $this->persister->flush();
    }
}
