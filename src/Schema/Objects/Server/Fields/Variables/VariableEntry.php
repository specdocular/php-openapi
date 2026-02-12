<?php

namespace Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables;

use Specdocular\OpenAPI\Schema\Objects\ServerVariable\ServerVariable;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * Server Variable entry.
 *
 * A single entry in the server variables map, representing a variable name
 * and its corresponding ServerVariable object.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#server-object
 *
 * @implements StringMapEntry<ServerVariable>
 */
final readonly class VariableEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<ServerVariable> */
    use StringKeyedMapEntry;

    public static function create(string $name, ServerVariable $serverVariable): self
    {
        return new self($name, $serverVariable);
    }
}
