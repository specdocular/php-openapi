<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Examples;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<OASObject>
 */
final readonly class Examples implements StringMap
{
    /** @use StringKeyedMap<OASObject> */
    use StringKeyedMap;

    public static function create(ExampleEntry ...$exampleEntry): self
    {
        return self::put(...$exampleEntry);
    }
}
