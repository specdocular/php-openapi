<?php

namespace Specdocular\OpenAPI\Support\Serialization;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Support\Style\Styles\Cookie;
use Specdocular\OpenAPI\Support\Style\Styles\Form;

final class CookieParameter extends SchemaSerialized
{
    public static function create(
        JSONSchema|SchemaFactory $jsonSchema,
        Cookie|Form|null $style = null,
    ): self {
        return new self(
            $jsonSchema,
            $style,
        );
    }
}
