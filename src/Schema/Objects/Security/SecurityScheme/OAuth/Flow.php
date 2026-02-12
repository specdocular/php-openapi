<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\OAuth;

use Specdocular\OpenAPI\Contracts\Abstract\ReadonlyGeneratable;

abstract readonly class Flow extends ReadonlyGeneratable
{
    protected ScopeCollection $scopeCollection;

    protected function __construct(
        protected string|null $refreshUrl,
        ScopeCollection|null $scopeCollection,
    ) {
        $this->scopeCollection = $scopeCollection ?? ScopeCollection::create();
    }

    public function scopeCollection(): ScopeCollection
    {
        return $this->scopeCollection;
    }
}
