<?php

namespace Specdocular\OpenAPI\Schema\Objects\Discriminator\Fields\Mapping;

use Specdocular\OpenAPI\Support\StringField;
use Specdocular\OpenAPI\Support\Validator;

final readonly class URL extends StringField
{
    private function __construct(
        private string $value,
    ) {
        Validator::url($value);
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
