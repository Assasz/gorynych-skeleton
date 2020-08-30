<?php

declare(strict_types=1);

namespace App\Ports\Operation\Client\TransactionCollection;

use App\Application\Resource\Client\Transaction\TransactionCollectionSubresource;
use App\Domain\Entity\Transaction;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/clients/{id}/transactions",
 *     summary="Inserts new Transaction item into collection resource.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/Transaction"),
 *     ),
 *     @OA\Response(
 *         response="201",
 *         description="Inserted Transaction resource IRI.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 example={"@id":"/transactions/1"},
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request.",
 *     ),
 * )
 */
final class InsertOperation extends AbstractOperation
{
    /** @var TransactionCollectionSubresource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::POST_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseStatus(): int
    {
        return Response::HTTP_CREATED;
    }

    /**
     * @return string[]
     */
    public function __invoke(Transaction $transaction): array
    {
        return ['@id' => $this->resource->insert($transaction)];
    }

    protected function getDeserializationContext(): array
    {
        return [
            'definition' => 'Transaction',
            'context' => [
                'groups' => ['write'],
            ],
        ];
    }
}
