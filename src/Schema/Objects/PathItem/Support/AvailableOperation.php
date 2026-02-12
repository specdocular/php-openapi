<?php

namespace Specdocular\OpenAPI\Schema\Objects\PathItem\Support;

use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<Operation>
 */
final readonly class AvailableOperation implements StringMapEntry
{
    /** @use StringKeyedMapEntry<Operation> */
    use StringKeyedMapEntry;

    public static function create(HttpMethod $method, Operation $operation): self
    {
        return new self($method->value, $operation);
    }
}
