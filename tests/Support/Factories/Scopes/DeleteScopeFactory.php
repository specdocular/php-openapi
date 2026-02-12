<?php

namespace Tests\Support\Factories\Scopes;

use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\Scope;
use Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth\ScopeFactory;

final readonly class DeleteScopeFactory extends ScopeFactory
{
    public function build(): Scope
    {
        return Scope::create('delete', 'Delete access');
    }
}
