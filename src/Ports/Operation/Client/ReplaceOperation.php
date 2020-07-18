<?php

declare(strict_types=1);

namespace App\Ports\Operation\Client;

use App\Domain\Entity\Client;
use App\Application\Resource\Client\ClientResource;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Put(
 *     path="/clients/{id}",
 *     summary="Replaces given Client resource with new one.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/Client"),
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Replaced Client resource IRI.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 example={"@id":"/clients/1"},
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
    /** @var ClientResource */
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
     * @param Request $request
     * @return string[]
     */
    public function __invoke(Request $request): array
    {
        /** @var Client $newClient */
        $newClient = $this->deserializeBody($request, Client::class);

        $this->validate($newClient, 'Client');
        $this->resource->replace($newClient);

        return $this->iriRepresentation();
    }
}
