<?php

use Specdocular\OpenAPI\Contracts\Abstract\Generatable;
use Tests\Support\Doubles\Fakes\GeneratableFake;

describe(class_basename(Generatable::class), function (): void {
    it('can be json serializable', function (): void {
        expect(Generatable::class)->toImplement(JsonSerializable::class);

        $object = new GeneratableFake();

        $result = $object->compile();

        expect($result)->toBe([]);
    });
})->covers(Generatable::class);
