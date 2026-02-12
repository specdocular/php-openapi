<?php

namespace Tests\Support\Doubles\Fakes;

use Specdocular\OpenAPI\Contracts\Abstract\Generatable;

class NonExtensibleObjectFake extends Generatable
{
    public function toArray(): array
    {
        return [];
    }
}
