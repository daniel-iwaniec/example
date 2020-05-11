<?php

declare(strict_types = 1);

namespace Example\Application\Exception;

use RuntimeException;
use Throwable;

class Unchecked extends RuntimeException
{
    public static function wrap(Throwable $exception): Unchecked
    {
        if ($exception instanceof static) {
            return $exception;
        }

        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }

    final private function __construct(string $message, int $code, Throwable $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}
