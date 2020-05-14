<?php

declare(strict_types = 1);

namespace Example\Web;

use Symfony\Component\HttpFoundation\Request;

/**
 * @template T
 * @extends Responder<T>
 */
interface CommonResponder extends Responder
{
    public function matches(Request $request): bool;
}
