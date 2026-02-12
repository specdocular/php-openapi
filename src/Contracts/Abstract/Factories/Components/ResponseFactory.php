<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;

abstract class ResponseFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/responses';
    }

    abstract public function component(): Response;
}
