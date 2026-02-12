<?php

namespace Specdocular\OpenAPI\Schema\Objects\Webhooks;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\Webhooks\Fields\Webhook;
use Specdocular\OpenAPI\Support\Map\StringKeyedMap;
use Specdocular\OpenAPI\Support\Map\StringMap;

/**
 * Webhooks Object.
 *
 * The incoming webhooks that MAY be received as part of this API and that the API consumer MAY choose to implement.
 * Closely related to the callbacks feature, this section describes requests initiated other than by an API call,
 * for example by an out of band registration.
 *
 * The key name is a unique string to refer to each webhook, while the (optionally referenced) PathItem Object
 * describes a request that may be initiated by the API provider and the expected responses.
 *
 * @implements StringMap<Webhook>
 *
 * @see https://spec.openapis.org/oas/v3.2.0#fixed-fields
 */
final class Webhooks extends ExtensibleObject implements StringMap
{
    /** @use StringKeyedMap<Webhook> */
    use StringKeyedMap {
        StringKeyedMap::jsonSerialize as jsonSerializeTrait;
    }

    public static function create(Webhook ...$webhook): self
    {
        return self::put(...$webhook);
    }

    public function toArray(): array
    {
        return $this->jsonSerialize() ?? [];
    }

    public function jsonSerialize(): array
    {
        return $this->jsonSerializeTrait() ?? [];
    }
}
