<?php

namespace Specdocular\OpenAPI\Schema\Objects\Info;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Fields\TermsOfService;
use Specdocular\OpenAPI\Schema\Objects\Info\Fields\Title;
use Specdocular\OpenAPI\Schema\Objects\Info\Fields\Version;
use Specdocular\OpenAPI\Schema\Objects\License\License;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;
use Specdocular\OpenAPI\Support\SharedFields\Summary;

/**
 * Info Object.
 *
 * Provides metadata about the API. The metadata MAY be used by tooling
 * as required. Title and version are required fields.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#info-object
 */
final class Info extends ExtensibleObject
{
    private Summary|null $summary = null;
    private Description|null $description = null;
    private TermsOfService|null $termsOfService = null;
    private Contact|null $contact = null;
    private License|null $license = null;

    private function __construct(
        private readonly Title $title,
        private readonly Version $version,
    ) {
    }

    /**
     * A short summary of the API.
     */
    public function summary(string $summary): self
    {
        $clone = clone $this;

        $clone->summary = Summary::create($summary);

        return $clone;
    }

    public static function create(
        string $title,
        string $version,
    ): self {
        return new self(Title::create($title), Version::create($version));
    }

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    public function termsOfService(string $termsOfService): self
    {
        $clone = clone $this;

        $clone->termsOfService = TermsOfService::create($termsOfService);

        return $clone;
    }

    public function contact(Contact $contact): self
    {
        $clone = clone $this;

        $clone->contact = $contact;

        return $clone;
    }

    public function license(License $license): self
    {
        $clone = clone $this;

        $clone->license = $license;

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter([
            'title' => $this->title,
            'summary' => $this->summary,
            'description' => $this->description,
            'termsOfService' => $this->termsOfService,
            'contact' => $this->contact,
            'license' => $this->license,
            'version' => $this->version,
        ]);
    }
}
