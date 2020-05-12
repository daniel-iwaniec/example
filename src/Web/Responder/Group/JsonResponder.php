<?php

declare(strict_types = 1);

namespace Example\Web\Responder\Group;

use Example\Web\CommonResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JsonResponder implements CommonResponder
{
    public function matches(Request $request): bool
    {
        return $request->isXmlHttpRequest();
    }

    public function __invoke($data): JsonResponse
    {
        return new JsonResponse($data);
    }
}
