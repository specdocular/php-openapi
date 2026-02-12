<?php

namespace Specdocular\OpenAPI\Contracts\Interface;

use Specdocular\OpenAPI\Schema\Objects\Components\Components;

interface ComponentMiddleware
{
    public function after(Components $components): void;
}
