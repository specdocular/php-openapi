<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Encodings;

use Specdocular\OpenAPI\Schema\Objects\Encoding\Encoding;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<EncodingMap>
 */
final readonly class EncodingEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<EncodingMap> */
    use StringKeyedMapEntry;

    public static function create(string $name, Encoding $encoding): self
    {
        return new self($name, $encoding);
    }
}
