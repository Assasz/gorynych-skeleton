<?php

declare(strict_types=1);

namespace App\Ports\Operation\Transaction;

use App\Domain\Entity\Transaction;
use App\Application\Resource\Transaction\TransactionResource;
use Gorynych\Operation\AbstractOperation;

/**
 * @OA\Put(
 *     path="/transactions/{id}",
 *     summary="Replaces given Transaction resource with new one.",
 *     tags={"Transaction"},
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
 *         response="200",
 *         description="Replaced Transaction resource IRI.",
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
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found.",
 *     ),
 * )
 */
final class ReplaceOperation extends AbstractOperation
{
    /** @var TransactionResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::PUT_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    /**
     * @return string[]
     */
    public function __invoke(Transaction $newTransaction): array
    {
        return ['@id' => $this->resource->replace($newTransaction)];
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
