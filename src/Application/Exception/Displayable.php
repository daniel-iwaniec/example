<?php

declare(strict_types = 1);

namespace Example\Application\Exception;

interface Displayable
{
    public function display(): string;
}
