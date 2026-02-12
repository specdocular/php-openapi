<?php

namespace Specdocular\OpenAPI\Schema\Objects\Discriminator\Fields\Mapping;

use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;
use Specdocular\OpenAPI\Support\StringField;

/**
 * @implements StringMap<StringField>
 */
final readonly class Mapping implements StringMap
{
    /** @use StringKeyedMap<StringField> */
    use StringKeyedMap;

    public static function create(Entry ...$entry): self
    {
        return self::put(...$entry);
    }
}
