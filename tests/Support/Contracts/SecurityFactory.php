<?php

namespace Tests\Support\Contracts;

use Specdocular\OpenAPI\Schema\Objects\Security\Security;

interface SecurityFactory
{
    public function build(): Security;
}
