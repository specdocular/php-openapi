<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Encodings;

use Specdocular\OpenAPI\Schema\Objects\Encoding\Encoding;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<Encoding>
 */
final readonly class EncodingMap implements StringMap
{
    /** @use StringKeyedMap<Encoding> */
    use StringKeyedMap;

    public static function create(EncodingEntry ...$encodingEntry): self
    {
        return self::put(...$encodingEntry);
    }
}
