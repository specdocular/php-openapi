<?php

namespace Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;
use Specdocular\OpenAPI\Support\SharedFields\URL;

/**
 * External Documentation Object.
 *
 * Allows referencing an external resource for extended documentation.
 * The url field is required and must be a valid URL.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#external-documentation-object
 */
final class ExternalDocumentation extends ExtensibleObject
{
    private Description|null $description = null;

    private function __construct(
        private readonly URL $url,
    ) {
    }

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    public static function create(string $url): self
    {
        return new self(URL::create($url));
    }

    public function toArray(): array
    {
        return Arr::filter([
            'url' => $this->url,
            'description' => $this->description,
        ]);
    }
}
