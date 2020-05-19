<?php

declare(strict_types = 1);

namespace Example\Web\Responder\Common;

use Example\Web\CommonResponder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class JsonResponder implements CommonResponder
{
    public function matches(Request $request): bool
    {
        return $request->isXmlHttpRequest();
    }

    public function respond(object $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    public function respondToException(Throwable $exception): JsonResponse
    {
        return new JsonResponse($exception->getMessage());
    }
}
