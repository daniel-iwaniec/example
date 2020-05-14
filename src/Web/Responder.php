<?php

declare(strict_types = 1);

namespace Example\Web;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @template T
 */
interface Responder
{
    /**
     * @param T $data
     */
    public function respond($data): Response;

    public function respondToException(Throwable $exception): Response;
}
