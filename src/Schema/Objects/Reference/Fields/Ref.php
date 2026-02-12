<?php

namespace Specdocular\OpenAPI\Schema\Objects\Reference\Fields;

use Specdocular\OpenAPI\Support\StringField;
use Specdocular\OpenAPI\Support\Validator;

final readonly class Ref extends StringField
{
    private function __construct(
        private string $value,
    ) {
        Validator::uri($value);
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
