<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Example\Example;

abstract class ExampleFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/examples';
    }

    abstract public function component(): Example;
}
