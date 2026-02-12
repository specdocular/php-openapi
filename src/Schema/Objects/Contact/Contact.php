<?php

namespace Specdocular\OpenAPI\Schema\Objects\Contact;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\Contact\Fields\Email;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Name;
use Specdocular\OpenAPI\Support\SharedFields\URL;

/**
 * Contact Object.
 *
 * Contact information for the exposed API. All fields are optional.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#contact-object
 */
final class Contact extends ExtensibleObject
{
    private Name|null $name = null;
    private URL|null $url = null;
    private Email|null $email = null;

    public function name(string $name): self
    {
        $clone = clone $this;

        $clone->name = Name::create($name);

        return $clone;
    }

    public static function create(): self
    {
        return new self();
    }

    public function url(string $url): self
    {
        $clone = clone $this;

        $clone->url = URL::create($url);

        return $clone;
    }

    public function email(string $email): self
    {
        $clone = clone $this;

        $clone->email = Email::create($email);

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'url' => $this->url,
            'email' => $this->email,
        ]);
    }
}
