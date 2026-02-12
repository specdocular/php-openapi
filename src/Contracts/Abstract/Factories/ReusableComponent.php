<?php

namespace Specdocular\OpenAPI\Contracts\Abstract\Factories;

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\OpenAPI\Contracts\Interface\OASObject;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Reference\Reference;
use Specdocular\OpenAPI\Support\Validator;

abstract class ReusableComponent implements \JsonSerializable, OASObject
{
    final public function __construct()
    {
    }

    final public function jsonSerialize(): JSONSchema|OASObject
    {
        return $this->build();
    }

    public function build(): JSONSchema|OASObject
    {
        if (is_a($this, ShouldBeReferenced::class)) {
            return self::reference();
        }

        return $this->component();
    }

    final public static function reference(): Reference
    {
        return Reference::create(static::uri());
    }

    final public static function create(): static
    {
        return new static();
    }

    protected static function uri(): string
    {
        $name = static::name();
        self::validateName($name);

        return self::baseNamespace() . static::componentNamespace() . '/' . $name;
    }

    public static function name(): string
    {
        return class_basename(static::class);
    }

    final protected static function validateName(string $name): void
    {
        Validator::componentName($name);
    }

    private static function baseNamespace(): string
    {
        return '#/components';
    }

    abstract protected static function componentNamespace(): string;

    abstract public function component(): JSONSchema|OASObject;
}
