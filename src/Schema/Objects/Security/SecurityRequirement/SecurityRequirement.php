<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityRequirement;

use Specdocular\OpenAPI\Contracts\Abstract\ReadonlyGeneratable;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Scope;
use Specdocular\OpenAPI\Support\Arr;

/**
 * Security Requirement Object.
 *
 * Lists the required security schemes to execute this operation. Each property
 * name MUST correspond to a security scheme declared in the Security Schemes
 * under the Components Object.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#security-requirement-object
 */
final readonly class SecurityRequirement extends ReadonlyGeneratable
{
    /**
     * @param RequiredSecurity[] $requiredSecurities
     */
    private function __construct(
        private array $requiredSecurities,
    ) {
    }

    public static function create(RequiredSecurity ...$requiredSecurity): self
    {
        return new self($requiredSecurity);
    }

    public function toArray(): array
    {
        $requiredSecurities = [];
        foreach ($this->requiredSecurities as $security) {
            $requiredSecurities[$security->scheme()] = array_map(
                static fn (Scope $scope): string => $scope->name(),
                $security->scopes(),
            );
        }

        return Arr::filter($requiredSecurities);
    }
}
