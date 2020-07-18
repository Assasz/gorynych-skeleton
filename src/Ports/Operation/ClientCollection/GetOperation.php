<?php

declare(strict_types=1);

namespace App\Ports\Operation\ClientCollection;

use App\Application\Resource\Client\ClientCollectionResource;
use Gorynych\Operation\AbstractOperation;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/clients",
 *     summary="Retrieves Client collection resource.",
 *     tags={"Client"},
 *     @OA\Response(
 *         response="200",
 *         description="The Client collection resource.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Client"),
 *             ),
 *         ),
 *     ),
 * )
 */
final class GetOperation extends AbstractOperation
{
    /** @var ClientCollectionResource */
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

    /**
     * @param Request $request
     * @return mixed[]
     */
    public function __invoke(Request $request): array
    {
        return $this->normalizeResource($this->resource->retrieve()->toList());
    }
}
