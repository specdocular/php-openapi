<?php

namespace Specdocular\OpenAPI\Schema\Objects\Responses\Support;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<OASObject>
 */
final readonly class ResponseMap implements StringMap
{
    /** @use StringKeyedMap<OASObject> */
    use StringKeyedMap;

    public static function create(ResponseEntry ...$entry): self
    {
        return self::put(...$entry);
    }
}
