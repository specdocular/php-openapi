<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Examples;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Schema\Objects\Example\Example;
use Specdocular\OpenAPI\Schema\Objects\Reference\Reference;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<OASObject>
 */
final readonly class ExampleEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<OASObject> */
    use StringKeyedMapEntry;

    public static function create(string $name, Example|Reference $example): self
    {
        return new self($name, $example);
    }
}
