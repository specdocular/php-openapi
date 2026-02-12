<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;

abstract class ParameterFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/parameters';
    }

    abstract public function component(): Parameter;
}
