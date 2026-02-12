<?php

namespace Specdocular\OpenAPI\Support\Style;

use Specdocular\OpenAPI\Contracts\Interface\MergeableFields;

/**
 * Style interface for parameter serialization styles.
 *
 * Defines how parameters are serialized. Fields from implementing classes
 * are merged into the parent object at the same level as the schema field.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#style-values
 */
interface Style extends MergeableFields
{
    public function toArray(): array;
}
