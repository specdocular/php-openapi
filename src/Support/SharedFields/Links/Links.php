<?php

namespace Specdocular\OpenAPI\Support\SharedFields\Links;

use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * @implements StringMap<OASObject>
 */
final readonly class Links implements StringMap
{
    /** @use StringKeyedMap<OASObject> */
    use StringKeyedMap;

    public static function create(LinkEntry ...$linkEntry): self
    {
        return self::put(...$linkEntry);
    }
}
