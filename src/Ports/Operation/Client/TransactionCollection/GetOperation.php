<?php

declare(strict_types=1);

namespace App\Ports\Operation\Client\TransactionCollection;

use App\Application\Resource\Client\Transaction\TransactionCollectionSubresource;
use Cake\Collection\Collection;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/clients/{id}/transactions",
 *     summary="Retrieves Transaction collection resource.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="The Transaction collection resource.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Transaction"),
 *             ),
 *         ),
 *     ),
 * )
 */
final class GetOperation extends AbstractOperation
{
    /** @var TransactionCollectionSubresource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::GET_METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '/';
    }

    public function __invoke(Request $request): Collection
    {
        return $this->resource->retrieveTransactions();
    }

    protected function getNormalizationContext(): array
    {
        return [
            'definition' => 'Transaction',
            'context' => [
                'groups' => ['read'],
            ],
        ];
    }
}
