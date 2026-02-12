<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\Link\Link;

abstract class LinkFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/links';
    }

    abstract public function component(): Link;
}
