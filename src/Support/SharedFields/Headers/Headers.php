<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Headers;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<OASObject>
 */
final readonly class Headers implements StringMap
{
    /** @use StringKeyedMap<OASObject> */
    use StringKeyedMap;

    public static function create(HeaderEntry ...$entry): self
    {
        return self::put(...$entry);
    }
}
