<?php

declare(strict_types=1);

namespace App\Application\Resource\Client\Transaction;

use App\Application\Contract\Provider\TransactionProviderInterface;
use App\Application\Resource\Client\ClientResource;
use App\Application\Resource\Transaction\TransactionResource;
use App\Domain\Entity\Transaction;
use Cake\Collection\Collection;
use Gorynych\Http\Exception\UnprocessableEntityHttpException;
use Gorynych\Resource\CollectionResourceInterface;

final class TransactionCollectionSubresource extends ClientResource implements CollectionResourceInterface
{
    private TransactionProviderInterface $transactionProvider;

    /**
     * @required
     */
    public function setTransactionProvider(TransactionProviderInterface $transactionProvider): void
    {
        $this->transactionProvider = $transactionProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return parent::getPath() . '/transactions/';
    }

    /**
     * @param mixed $item
     */
    public function supportsTransaction($item): bool
    {
        return $item instanceof Transaction;
    }

    /**
     * @return Transaction[]|Collection
     */
    public function retrieveTransactions(): Collection
    {
        return new Collection($this->transactionProvider->fetchByClient((int)$this->id));
    }

    /**
     * {@inheritdoc}
     * @throws UnprocessableEntityHttpException
     */
    public function insert($item): string
    {
        if (false === $this->supportsTransaction($item)) {
            throw new UnprocessableEntityHttpException();
        }

        /** @var Transaction $item */
        $item->setId(strtoupper(bin2hex(random_bytes(16))));

        $this->retrieve()->addTransaction($item);
        $this->persister->persist($item);
        $this->save();

        return sprintf(TransactionResource::PATH_PATTERN, $item->getId());
    }
}
