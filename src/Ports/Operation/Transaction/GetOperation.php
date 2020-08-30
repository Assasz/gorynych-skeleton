<?php

declare(strict_types=1);

namespace App\Ports\Operation\Transaction;

use App\Application\Resource\Transaction\TransactionResource;
use App\Domain\Entity\Transaction;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/transactions/{id}",
 *     summary="Retrieves given Transaction resource.",
 *     tags={"Transaction"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="The Transaction resource.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Transaction",
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found.",
 *     ),
 * )
 */
final class GetOperation extends AbstractOperation
{
    /** @var TransactionResource */
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

    public function __invoke(Request $request): Transaction
    {
        return $this->resource->retrieve();
    }

    protected function getNormalizationContext(): array
    {
        return [
            'definition' => 'Transaction',
            'context' => [
                'groups' => ['read_single'],
            ],
        ];
    }
}
