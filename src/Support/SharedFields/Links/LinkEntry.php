<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Links;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Schema\Objects\Link\Link;
use Specdocular\OpenAPI\Schema\Objects\Reference\Reference;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<OASObject>
 */
final readonly class LinkEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<OASObject> */
    use StringKeyedMapEntry;

    public static function create(string $name, Link|Reference $link): self
    {
        return new self($name, $link);
    }
}
