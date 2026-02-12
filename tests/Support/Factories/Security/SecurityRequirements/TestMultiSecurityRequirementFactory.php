<?php

namespace Tests\Support\Factories\Security\SecurityRequirements;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Composable\SecurityRequirementFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\RequiredSecurity;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeCollection;
use Tests\Support\Factories\Security\Scopes\OrderShippingAddressScope;
use Tests\Support\Factories\Security\Scopes\OrderShippingStatusScope;
use Tests\Support\Factories\Security\SecuritySchemes\TestBearerSecuritySchemeFactory;
use Tests\Support\Factories\Security\SecuritySchemes\TestOAuth2PasswordSecuritySchemeFactory;

/**
 * @extends SecurityRequirementFactory<SecurityRequirement>
 */
final class TestMultiSecurityRequirementFactory extends SecurityRequirementFactory
{
    public function object(): SecurityRequirement
    {
        return SecurityRequirement::create(
            RequiredSecurity::create(
                TestBearerSecuritySchemeFactory::create(),
            ),
            RequiredSecurity::create(
                TestOAuth2PasswordSecuritySchemeFactory::create(),
                ScopeCollection::create(
                    OrderShippingAddressScope::create(),
                    OrderShippingStatusScope::create(),
                ),
            ),
        );
    }
}
