<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;

abstract class HeaderFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/headers';
    }

    abstract public function component(): Header;
}
