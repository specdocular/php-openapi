<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Headers;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;
use Specdocular\OpenAPI\Schema\Objects\Reference\Reference;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<OASObject>
 */
final readonly class HeaderEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<OASObject> */
    use StringKeyedMapEntry;

    public static function create(string $name, Header|Reference $header): self
    {
        return new self($name, $header);
    }
}
