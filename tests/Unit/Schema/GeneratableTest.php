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

    it('preserves empty objects as objects and empty arrays as arrays through compile', function (): void {
        $object = new class extends Generatable {
            public function toArray(): array
            {
                return [
                    'emptyObject' => new stdClass(),
                    'emptyArray' => [],
                    'nested' => ['deepEmptyObject' => new stdClass()],
                ];
            }
        };

        $json = json_encode($object->compile(), JSON_UNESCAPED_SLASHES);

        expect($json)->toContain('"emptyObject":{}')
            ->and($json)->toContain('"emptyArray":[]')
            ->and($json)->toContain('"deepEmptyObject":{}');
    });
})->covers(Generatable::class);
