<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;

abstract class RequestBodyFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/requestBodies';
    }

    abstract public function component(): RequestBody;
}
