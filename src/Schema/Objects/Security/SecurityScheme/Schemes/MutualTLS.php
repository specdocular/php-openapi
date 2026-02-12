<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Schemes;

use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Contracts\Scheme;

final readonly class MutualTLS implements Scheme
{
    public static function create(): self
    {
        return new self();
    }

    public function type(): string
    {
        return 'mutualTLS';
    }

    public function jsonSerialize(): array|null
    {
        return [];
    }
}
