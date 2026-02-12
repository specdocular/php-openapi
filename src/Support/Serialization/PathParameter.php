<?php

namespace Specdocular\OpenAPI\Support\Serialization;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Support\Style\Styles\Label;
use Specdocular\OpenAPI\Support\Style\Styles\Matrix;
use Specdocular\OpenAPI\Support\Style\Styles\Simple;

final class PathParameter extends SchemaSerialized
{
    public static function create(
        JSONSchema|SchemaFactory $jsonSchema,
        Label|Matrix|Simple|null $style = null,
    ): self {
        return new self(
            $jsonSchema,
            $style,
        );
    }
}
