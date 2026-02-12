<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Contracts\Scheme;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Fields\OpenIdConnectUrl;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\ApiKey;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\Http;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\MutualTLS;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\OAuth2;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes\OpenIdConnect;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;

/**
 * Security Scheme Object.
 *
 * Defines a security scheme that can be used by the operations. Supported
 * schemes are HTTP authentication, API key, mutual TLS, OAuth2, and
 * OpenID Connect Discovery.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#security-scheme-object
 */
final class SecurityScheme extends ExtensibleObject
{
    private Description|null $description = null;

    /**
     * Declares this security scheme to be deprecated.
     *
     * Consumers SHOULD refrain from usage of the declared scheme.
     * Default value is false.
     *
     * @see https://spec.openapis.org/oas/v3.2.0#security-scheme-object
     */
    private true|null $deprecated = null;

    private function __construct(
        private readonly Scheme $scheme,
    ) {
    }

    public static function apiKey(ApiKey $apiKey): self
    {
        return new self($apiKey);
    }

    public static function http(Http $http): self
    {
        return new self($http);
    }

    public static function mutualTLS(MutualTLS $mutualTLS): self
    {
        return new self($mutualTLS);
    }

    public static function oAuth2(OAuth2 $oAuth2): self
    {
        return new self($oAuth2);
    }

    public static function openIdConnect(string $openIdConnectUrl): self
    {
        return new self(OpenIdConnect::create(OpenIdConnectUrl::create($openIdConnectUrl)));
    }

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    /**
     * Mark this security scheme as deprecated.
     *
     * Consumers SHOULD refrain from usage of the declared scheme.
     */
    public function deprecated(): self
    {
        $clone = clone $this;

        $clone->deprecated = true;

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter([
            'type' => $this->scheme->type(),
            'description' => $this->description,
            'deprecated' => $this->deprecated,
            ...$this->mergeFields($this->scheme),
        ]);
    }
}
