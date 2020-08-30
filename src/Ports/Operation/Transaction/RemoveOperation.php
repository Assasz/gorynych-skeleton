<?php

declare(strict_types=1);

namespace App\Ports\Operation\Transaction;

use App\Application\Resource\Transaction\TransactionResource;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Delete(
 *     path="/transactions/{id}",
 *     summary="Removes given Transaction resource.",
 *     tags={"Transaction"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response="204",
 *         description="The Transaction resource is removed.",
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found.",
 *     ),
 * )
 */
final class RemoveOperation extends AbstractOperation
{
    /** @var TransactionResource */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return AbstractOperation::DELETE_METHOD;
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
        return Response::HTTP_NO_CONTENT;
    }

    public function __invoke(Request $request): void
    {
        $this->resource->remove();
    }
}
