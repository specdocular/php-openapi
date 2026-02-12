<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes;

use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Contracts\Scheme;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\OAuthFlows;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Scope;
use Specdocular\OpenAPI\Support\Arr;

final readonly class OAuth2 implements Scheme
{
    /**
     * @param OAuthFlows $OAuthFlows OAuth flows configuration
     * @param string|null $oauth2MetadataUrl URL for OAuth 2.0 Authorization Server Metadata (RFC 8414)
     */
    private function __construct(
        private OAuthFlows $OAuthFlows,
        private string|null $oauth2MetadataUrl = null,
    ) {
    }

    public static function create(OAuthFlows $OAuthFlows, string|null $oauth2MetadataUrl = null): self
    {
        return new self($OAuthFlows, $oauth2MetadataUrl);
    }

    public function type(): string
    {
        return 'oauth2';
    }

    public function containsAllScopes(Scope ...$scope): bool
    {
        return $this->OAuthFlows->scopeCollection()->containsAll(...$scope);
    }

    public function availableScopes(): array
    {
        return $this->OAuthFlows->scopeCollection()->all();
    }

    public function jsonSerialize(): array|null
    {
        return Arr::filter([
            'oauth2MetadataUrl' => $this->oauth2MetadataUrl,
            'flows' => $this->OAuthFlows,
        ]);
    }
}
