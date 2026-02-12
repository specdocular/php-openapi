<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Content;

use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<MediaType>
 */
final readonly class Content implements StringMap
{
    /** @use StringKeyedMap<MediaType> */
    use StringKeyedMap;

    public static function create(ContentEntry ...$entry): self
    {
        return self::put(...$entry);
    }
}
