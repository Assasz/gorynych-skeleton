<?php

declare(strict_types=1);

namespace App\Application\Resource\Transaction;

use App\Application\Contract\Persister\PersistenceAwareTrait;
use App\Application\Contract\Provider\TransactionProviderInterface;
use App\Domain\Entity\Transaction;
use Gorynych\Http\Exception\NotFoundHttpException;
use Gorynych\Http\Exception\UnprocessableEntityHttpException;
use Gorynych\Resource\AbstractResource;
use Gorynych\Resource\ResourceInterface;

class TransactionResource extends AbstractResource implements ResourceInterface
{
    use PersistenceAwareTrait;

    public const PATH_PATTERN = '/transactions/%s';

    private TransactionProviderInterface $transactionProvider;

    public function __construct(TransactionProviderInterface $transactionProvider)
    {
        $this->transactionProvider = $transactionProvider;
    }

    public function getPath(): string
    {
        return sprintf(self::PATH_PATTERN, $this->id ?? self::ALNUM_ID);
    }

    public function supports($item): bool
    {
        return $item instanceof Transaction;
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundHttpException
     */
    public function retrieve(): Transaction
    {
        $transaction = $this->transactionProvider->fetchOne($this->id);

        if (false === $this->supports($transaction)) {
            throw new NotFoundHttpException();
        }

        return $transaction;
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

        /** @var Transaction $item */
        $item->setId($this->id);
        $item->setClient($this->retrieve()->getClient());

        $this->persister->replace($item);
        $this->save();

        return $this->getPath();
    }

    public function save(): void
    {
        $this->persister->flush();
    }
}
