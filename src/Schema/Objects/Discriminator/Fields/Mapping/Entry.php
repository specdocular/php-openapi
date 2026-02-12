<?php

namespace Specdocular\OpenAPI\Schema\Objects\Discriminator\Fields\Mapping;

use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;
use Specdocular\OpenAPI\Support\StringField;

/**
 * @implements StringMapEntry<StringField>
 */
final readonly class Entry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<StringField> */
    use StringKeyedMapEntry;

    public static function create(string $payloadValue, Name|URL $nameOrUrl): self
    {
        return new self($payloadValue, $nameOrUrl);
    }
}
