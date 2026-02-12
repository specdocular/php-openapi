<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;

abstract class PathItemFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/pathItems';
    }

    abstract public function component(): PathItem;
}
