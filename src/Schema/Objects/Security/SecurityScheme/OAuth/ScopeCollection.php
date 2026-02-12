<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth;

use Specdocular\OpenAPI\Contracts\Abstract\ReadonlyGeneratable;
use Specdocular\OpenAPI\Support\Arr;

final readonly class ScopeCollection extends ReadonlyGeneratable
{
    private array $scopeFactories;

    private function __construct(ScopeFactory ...$scopeFactory)
    {
        $this->scopeFactories = $scopeFactory;
    }

    public static function create(ScopeFactory ...$scopeFactory): self
    {
        return new self(...$scopeFactory);
    }

    public function containsAll(Scope ...$scope): bool
    {
        foreach ($scope as $currentScope) {
            if (!$this->contains($currentScope)) {
                return false;
            }
        }

        return true;
    }

    public function contains(Scope $scope): bool
    {
        foreach ($this->all() as $currentScope) {
            if (true === $currentScope->equals($scope)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all scopes.
     *
     * @return Scope[]
     */
    public function all(): array
    {
        return $this->buildScopes(...$this->scopeFactories);
    }

    private function buildScopes(ScopeFactory ...$scopeFactory): array
    {
        return array_map(static fn (ScopeFactory $scopeFactory): Scope => $scopeFactory->build(), $scopeFactory);
    }

    public function merge(self $scopeCollection): self
    {
        return new self(...$this->scopeFactories, ...$scopeCollection->scopeFactories());
    }

    public function scopeFactories(): array
    {
        return $this->scopeFactories;
    }

    public function toArray(): array
    {
        $scopes = array_reduce($this->all(), static function (array $carry, Scope $scope) {
            $carry[$scope->name()] = $scope->description();

            return $carry;
        }, []);

        return Arr::filter($scopes);
    }
}
