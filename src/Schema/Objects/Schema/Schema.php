<?php

namespace Specdocular\OpenAPI\Schema\Objects\Schema;

use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\ArrayRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\BooleanRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\ConstantRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\EnumRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\IntegerRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\NullRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\NumberRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\ObjectRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\RefRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\SharedRestrictor;
use Specdocular\JsonSchema\Draft202012\Contracts\Restrictors\StringRestrictor;
use Specdocular\JsonSchema\Draft202012\StrictFluentDescriptor;

final class Schema
{
    public static function from(array $data): ObjectRestrictor
    {
        return StrictFluentDescriptor::from($data);
    }

    public static function null(): NullRestrictor
    {
        return StrictFluentDescriptor::null();
    }

    public static function boolean(): BooleanRestrictor
    {
        return StrictFluentDescriptor::boolean();
    }

    public static function string(): StringRestrictor
    {
        return StrictFluentDescriptor::string();
    }

    public static function integer(): IntegerRestrictor
    {
        return StrictFluentDescriptor::integer();
    }

    public static function number(): NumberRestrictor
    {
        return StrictFluentDescriptor::number();
    }

    public static function object(): ObjectRestrictor
    {
        return StrictFluentDescriptor::object();
    }

    public static function array(): ArrayRestrictor
    {
        return StrictFluentDescriptor::array();
    }

    public static function const(mixed $value): ConstantRestrictor
    {
        return StrictFluentDescriptor::constant($value);
    }

    public static function enum(mixed ...$value): EnumRestrictor
    {
        return StrictFluentDescriptor::enumerator(...$value);
    }

    public static function ref(string $ref): RefRestrictor
    {
        return StrictFluentDescriptor::withoutSchema()->ref($ref);
    }

    public static function oneOf(StrictFluentDescriptor ...$schemas): SharedRestrictor
    {
        return StrictFluentDescriptor::withoutSchema()->oneOf(...$schemas);
    }

    public static function anyOf(StrictFluentDescriptor ...$schemas): SharedRestrictor
    {
        return StrictFluentDescriptor::withoutSchema()->anyOf(...$schemas);
    }

    public static function allOf(StrictFluentDescriptor ...$schemas): SharedRestrictor
    {
        return StrictFluentDescriptor::withoutSchema()->allOf(...$schemas);
    }
}
