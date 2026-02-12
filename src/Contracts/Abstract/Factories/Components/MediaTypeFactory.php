<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;

abstract class MediaTypeFactory extends ReusableComponent
{
    final protected static function componentNamespace(): string
    {
        return '/mediaTypes';
    }

    abstract public function component(): MediaType;
}
