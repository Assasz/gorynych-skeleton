<?php

declare(strict_types=1);

namespace App\Ports\Operation\Client;

use App\Application\Resource\Client\ClientResource;
use App\Domain\Entity\Client;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/clients/{id}",
 *     summary="Retrieves given Client resource.",
 *     tags={"Client"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="The Client resource.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Client",
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
    /** @var ClientResource */
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

    public function __invoke(Request $request): Client
    {
        return $this->resource->retrieve();
    }

    /**
     * {@inheritdoc}
     */
    protected function getNormalizationContext(): array
    {
        return [
            'definition' => 'Client',
            'context' => [
                'groups' => ['read'],
            ],
        ];
    }
}
