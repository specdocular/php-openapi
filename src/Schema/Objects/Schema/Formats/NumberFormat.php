<?php

namespace Specdocular\OpenAPI\Schema\Objects\Schema\Formats;

use Specdocular\JsonSchema\Draft202012\Formats\DefinedFormat;

enum NumberFormat: string implements DefinedFormat
{
    case FLOAT = 'float';

    case DOUBLE = 'double';

    public function value(): string
    {
        return $this->value;
    }
}
