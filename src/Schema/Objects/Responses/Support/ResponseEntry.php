<?php

namespace Specdocular\OpenAPI\Schema\Objects\Responses\Support;

use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\ResponseFactory;
use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Schema\Objects\Reference\Reference;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\DefaultResponse;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Support\Map\StringKeyedMapEntry;
use Specdocular\OpenAPI\Support\Map\StringMapEntry;

/**
 * @implements StringMapEntry<OASObject>
 */
final readonly class ResponseEntry implements StringMapEntry
{
    /** @use StringKeyedMapEntry<OASObject> */
    use StringKeyedMapEntry;

    public static function create(
        DefaultResponse|HTTPStatusCode $name,
        Response|ResponseFactory|Reference $response,
    ): self {
        return new self($name, $response);
    }
}
