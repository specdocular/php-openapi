<?php

namespace Tests\Support\Doubles\Fakes;

use Specdocular\OpenAPI\Contracts\Abstract\Generatable;

class GeneratableFake extends Generatable
{
    public function toArray(): array
    {
        return [];
    }
}
