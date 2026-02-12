<?php

namespace Specdocular\OpenAPI\Schema\Objects\Discriminator\Fields\Mapping;

use Specdocular\OpenAPI\Support\StringField;

final readonly class Name extends StringField
{
    private function __construct(
        private string $value,
    ) {
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
