<?php

namespace Specdocular\OpenAPI\Support\Serialization;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Support\Style\Styles\Simple;

final class HeaderParameter extends SchemaSerialized
{
    public static function create(
        JSONSchema|SchemaFactory $jsonSchema,
        Simple|null $style = null,
    ): self {
        return new self(
            $jsonSchema,
            $style,
        );
    }
}
