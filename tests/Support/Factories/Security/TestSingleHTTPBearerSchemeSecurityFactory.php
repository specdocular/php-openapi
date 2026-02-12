<?php

namespace Tests\Support\Factories\Security;

use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Tests\Support\Contracts\SecurityFactory;
use Tests\Support\Factories\Security\SecurityRequirements\TestBearerSecurityRequirementFactory;

class TestSingleHTTPBearerSchemeSecurityFactory implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            TestBearerSecurityRequirementFactory::create(),
        );
    }
}
