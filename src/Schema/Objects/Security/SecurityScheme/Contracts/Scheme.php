<?php

namespace Specdocular\OpenAPI\Schema\Objects\Security\SecurityScheme\Contracts;

use Specdocular\OpenAPI\Contracts\Interface\MergeableFields;

/**
 * Security scheme type interface.
 *
 * Defines the authentication mechanism for a SecurityScheme. Fields from
 * implementing classes are merged into the parent SecurityScheme object
 * at the same level as type and description.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#security-scheme-object
 */
interface Scheme extends MergeableFields
{
    public function type(): string;
}
