<?php

namespace Specdocular\OpenAPI\Support\Serialization;

use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

/**
 * @implements StringMap<MediaType>
 */
final readonly class Content implements SerializationRule, StringMap
{
    /** @use StringKeyedMap<MediaType> */
    use StringKeyedMap {
        StringKeyedMap::jsonSerialize as jsonSerializeTrait;
    }

    public static function create(ContentEntry $contentEntry): self
    {
        return self::put($contentEntry);
    }

    public function jsonSerialize(): array
    {
        return ['content' => $this->jsonSerializeTrait()];
    }
}
