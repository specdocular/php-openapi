<?php

namespace Specdocular\OpenAPI\Schema\Objects\Responses\Fields;

use Specdocular\OpenAPI\Support\StringField;

final readonly class DefaultResponse extends StringField
{
    public static function create(): self
    {
        return new self();
    }

    public function value(): string
    {
        return 'default';
    }
}
