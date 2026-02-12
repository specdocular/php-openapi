<?php

namespace Specdocular\OpenAPI\Schema\Objects\Webhooks\Fields;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * Represents a single webhook entry in the webhooks map.
 *
 * The key is the webhook name (identifier), and the value is a PathItem
 * describing the webhook's request structure.
 *
 * @implements StringMapEntry<PathItem>
 *
 * @see https://spec.openapis.org/oas/v3.2.0#fixed-fields
 */
final class Webhook extends ExtensibleObject implements StringMapEntry
{
    /** @use StringKeyedMapEntry<PathItem> */
    use StringKeyedMapEntry;

    public static function create(string $name, PathItem $pathItem): self
    {
        return new self($name, $pathItem);
    }

    public function toArray(): array
    {
        return [];
    }
}
