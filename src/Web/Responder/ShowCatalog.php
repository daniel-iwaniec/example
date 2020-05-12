<?php

declare(strict_types = 1);

namespace Example\Web\Responder;

use Example\Web\Responder;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowCatalog implements Responder
{
    public function __invoke(string $catalog): JsonResponse
    {
        return new JsonResponse($catalog);
    }
}
