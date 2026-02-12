<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;

abstract class CallbackFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/callbacks';
    }

    abstract public function component(): Callback;
}
