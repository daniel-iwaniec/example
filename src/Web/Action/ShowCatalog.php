<?php

declare(strict_types = 1);

namespace Example\Web\Action;

use stdClass;

class ShowCatalog
{
    public function __invoke(): stdClass
    {
        $response = new stdClass();
        $response->message = 'message';

        return $response;
    }
}
