<?php

declare(strict_types = 1);

namespace Example\Web\Responder;

use Example\Web\Responder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * @implements Responder<string>
 */
class ShowCatalog implements Responder
{
    public function respond($catalog): JsonResponse
    {
        return new JsonResponse($catalog);
    }

    public function respondToException(Throwable $exception): JsonResponse
    {
        return new JsonResponse($exception->getMessage());
    }
}
