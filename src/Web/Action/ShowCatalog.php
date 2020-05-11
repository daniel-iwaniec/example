<?php

declare(strict_types = 1);

namespace Example\Web\Action;

use Example\Web\Action;

class ShowCatalog implements Action
{
    public function __invoke(): string
    {
        return 'catalog';
    }
}
