<?php

namespace Specdocular\OpenAPI\Schema\Objects\PathItem\Support;

use Specdocular\OpenAPI\Contracts\Interface\MergeableFields;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * Collection of HTTP method operations for a PathItem.
 *
 * Operations (get, post, put, etc.) are merged into the parent PathItem
 * at the same level as summary and description, not nested under an
 * "operations" key.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#path-item-object
 *
 * @implements StringMap<Operation>
 */
final readonly class Operations implements StringMap, MergeableFields
{
    /** @use StringKeyedMap<Operation> */
    use StringKeyedMap;

    public static function create(AvailableOperation ...$availableOperation): self
    {
        return self::put(...$availableOperation);
    }
}
