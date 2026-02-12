<?php

namespace Tests\Unit\Schema\Objects\Security;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\RequiredSecurity;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement\SecurityRequirement;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Flows\ClientCredentials;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\OAuthFlows;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeCollection;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\ApiKey;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\Http;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\OAuth2;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\SecurityScheme;
use Tests\Support\Factories\Scopes\ReadScopeFactory;

describe(class_basename(Security::class), function (): void {
    it('can be created with single security requirement', function (): void {
        $apiKeyFactory = new class extends SecuritySchemeFactory {
            public function component(): SecurityScheme
            {
                return SecurityScheme::apiKey(ApiKey::header('X-API-Key'));
            }

            public static function name(): string
            {
                return 'ApiKeyAuth';
            }
        };

        $security = Security::create(
            SecurityRequirement::create(
                RequiredSecurity::create($apiKeyFactory),
            ),
        );

        expect($security->compile())->toBe([
            ['ApiKeyAuth' => []],
        ]);
    });

    it('can be created with multiple security requirements', function (): void {
        $apiKeyFactory = new class extends SecuritySchemeFactory {
            public function component(): SecurityScheme
            {
                return SecurityScheme::apiKey(ApiKey::header('X-API-Key'));
            }

            public static function name(): string
            {
                return 'ApiKeyAuth';
            }
        };

        $oauth2Factory = new class extends SecuritySchemeFactory {
            public function component(): SecurityScheme
            {
                return SecurityScheme::oAuth2(
                    OAuth2::create(
                        OAuthFlows::create(
                            clientCredentials: ClientCredentials::create(
                                'https://example.com/oauth/token',
                                scopeCollection: ScopeCollection::create(ReadScopeFactory::create()),
                            ),
                        ),
                    ),
                );
            }

            public static function name(): string
            {
                return 'OAuth2Auth';
            }
        };

        $security = Security::create(
            SecurityRequirement::create(
                RequiredSecurity::create($apiKeyFactory),
            ),
            SecurityRequirement::create(
                RequiredSecurity::create(
                    $oauth2Factory,
                    ScopeCollection::create(ReadScopeFactory::create()),
                ),
            ),
        );

        expect($security->compile())->toHaveCount(2)
            ->and($security->compile()[0])->toBe(['ApiKeyAuth' => []])
            ->and($security->compile()[1])->toBe(['OAuth2Auth' => ['read']]);
    });

    it('can merge two security collections', function (): void {
        $apiKeyFactory = new class extends SecuritySchemeFactory {
            public function component(): SecurityScheme
            {
                return SecurityScheme::apiKey(ApiKey::header('X-API-Key'));
            }

            public static function name(): string
            {
                return 'ApiKeyAuth';
            }
        };

        $basicFactory = new class extends SecuritySchemeFactory {
            public function component(): SecurityScheme
            {
                return SecurityScheme::http(Http::basic());
            }

            public static function name(): string
            {
                return 'BasicAuth';
            }
        };

        $security1 = Security::create(
            SecurityRequirement::create(
                RequiredSecurity::create($apiKeyFactory),
            ),
        );

        $security2 = Security::create(
            SecurityRequirement::create(
                RequiredSecurity::create($basicFactory),
            ),
        );

        $merged = $security1->merge($security2);

        expect($merged->compile())->toHaveCount(2);
    });

    it('can be created with empty security requirement for anonymous access', function (): void {
        $security = Security::create(
            SecurityRequirement::create(),
        );

        // Empty security requirement becomes stdClass (empty object {})
        expect($security->compile())->toHaveCount(1);
    });
})->covers(Security::class);
