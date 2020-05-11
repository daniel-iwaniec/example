<?php

declare(strict_types = 1);

namespace Example\Application\Exception;

use LogicException;
use Throwable;

class Checked extends LogicException
{
    public static function wrap(Throwable $exception): Checked
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
