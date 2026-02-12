<?php

namespace Tests\Support\Factories\Security\SecuritySchemes;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Flows\Password;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\OAuthFlows;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeCollection;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\OAuth2;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;
use Tests\Support\Factories\Security\Scopes\OrderItemScope;
use Tests\Support\Factories\Security\Scopes\OrderPaymentScope;
use Tests\Support\Factories\Security\Scopes\OrderScope;
use Tests\Support\Factories\Security\Scopes\OrderShippingAddressScope;
use Tests\Support\Factories\Security\Scopes\OrderShippingStatusScope;

class TestOAuth2PasswordSecuritySchemeFactory extends SecuritySchemeFactory
{
    public static function name(): string
    {
        return 'OAuth2Password';
    }

    public function component(): SecurityScheme
    {
        return SecurityScheme::oAuth2(
            OAuth2::create(
                OAuthFlows::create(
                    password: Password::create(
                        'https://laragen.io/oauth/authorize',
                        'https://laragen.io/oauth/token',
                        ScopeCollection::create(
                            OrderScope::create(),
                            OrderItemScope::create(),
                            OrderPaymentScope::create(),
                            OrderShippingAddressScope::create(),
                            OrderShippingStatusScope::create(),
                        ),
                    ),
                ),
            ),
        )->description('OAuth2 Password Security');
    }
}
