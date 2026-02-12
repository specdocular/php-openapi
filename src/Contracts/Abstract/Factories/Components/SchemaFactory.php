<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories\Components;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchemaFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\ReusableComponent;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;

abstract class SchemaFactory extends ReusableComponent implements JSONSchemaFactory
{
    final protected static function componentNamespace(): string
    {
        return '/schemas';
    }

    final public function build(): JSONSchema
    {
        if (is_a($this, ShouldBeReferenced::class)) {
            return Schema::ref(self::uri());
        }

        return $this->component();
    }

    abstract public function component(): JSONSchema;
}
