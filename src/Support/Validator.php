<?php

namespace Specdocular\OpenAPI\Support;

use Specdocular\OpenAPI\Support\Rules\ComponentName;
use Specdocular\OpenAPI\Support\Rules\JsonPointer;
use Specdocular\OpenAPI\Support\Rules\URI;
use Specdocular\OpenAPI\Support\Rules\URL;

final readonly class Validator
{
    public static function url(string $value): void
    {
        new URL($value);
    }

    public static function uri(string $value): void
    {
        new URI($value);
    }

    public static function componentName(string $value): void
    {
        new ComponentName($value);
    }

    public static function jsonPointer(string $value): void
    {
        new JsonPointer($value);
    }
}
