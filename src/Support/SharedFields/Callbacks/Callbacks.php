<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Callbacks;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<OASObject>
 */
final readonly class Callbacks implements StringMap
{
    /** @use StringKeyedMap<OASObject> */
    use StringKeyedMap;

    public static function create(CallbackEntry ...$callbackEntry): self
    {
        return self::put(...$callbackEntry);
    }
}
