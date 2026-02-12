<?php

namespace Specdocular\OpenAPI\Support\Serialization;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Support\Style\Styles\DeepObject;
use Specdocular\OpenAPI\Support\Style\Styles\Form;
use Specdocular\OpenAPI\Support\Style\Styles\PipeDelimited;
use Specdocular\OpenAPI\Support\Style\Styles\SpaceDelimited;

final class QueryParameter extends SchemaSerialized
{
    public static function create(
        JSONSchema|SchemaFactory $jsonSchema,
        DeepObject|Form|PipeDelimited|SpaceDelimited|null $style = null,
    ): self {
        return new self(
            $jsonSchema,
            $style,
        );
    }
}
