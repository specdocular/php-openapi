<?php

namespace Tests\Support\Doubles\Fakes;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;

final class ExtensibleObjectFake extends ExtensibleObject
{
    public static function create(): self
    {
        return new self();
    }

    public function toArray(): array
    {
        return [];
    }
}
