<?php

use Specdocular\OpenAPI\Contracts\Abstract\Generatable;
use Specdocular\OpenAPI\Contracts\Abstract\NonExtensibleObject;
use Tests\Support\Doubles\Fakes\NonExtensibleObjectFake;

describe(class_basename(NonExtensibleObject::class), function (): void {
    it('can be created', function (): void {
        expect(NonExtensibleObjectFake::class)
            ->toExtend(Generatable::class);
    });
})->covers(NonExtensibleObject::class);
