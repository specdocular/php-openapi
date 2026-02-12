<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;

abstract class SecuritySchemeFactory extends ReusableComponent implements ShouldBeReferenced
{
    final protected static function componentNamespace(): string
    {
        return '/securitySchemes';
    }

    abstract public function component(): SecurityScheme;
}
