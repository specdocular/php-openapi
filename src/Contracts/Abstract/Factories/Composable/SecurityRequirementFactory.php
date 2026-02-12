<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Composable;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\ComposableFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;

/**
 * @template T of SecurityRequirement
 *
 * @extends ComposableFactory<T>
 */
abstract class SecurityRequirementFactory extends ComposableFactory
{
    abstract public function object(): SecurityRequirement;
}
