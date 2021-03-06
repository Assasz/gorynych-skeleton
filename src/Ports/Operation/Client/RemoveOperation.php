<?php

declare(strict_types=1);

namespace App\Ports\Operation\Client;

use App\Application\Resource\Client\ClientResource;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Delete(
 *     path="/clients/{id}",
 *     summary="Removes given Client resource.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response="204",
 *         description="The Client resource is removed.",
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found.",
 *     ),
 * )
 */
final class RemoveOperation extends AbstractOperation
{
    /** @var ClientResource */
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
