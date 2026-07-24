<?php

namespace Specdocular\OpenAPI\Support;

use Specdocular\OpenAPI\Extensions\Extension;

/** @internal */
class Arr
{
    public static function filter(array $array): array
    {
        // A list is a value-array (examples/enum/default/const, or an OAS
        // collection): its null elements are values, never unset fields.
        $isList = array_is_list($array);

        foreach ($array as $index => &$value) {
            if ($value instanceof \JsonSerializable) {
                $value = $value->jsonSerialize();
            }

            // If the value is a filled array, then recursively filter it.
            if (is_array($value)) {
                $value = static::filter($value);
                continue;
            }

            // A list's elements are never null-pruned; only recursed (above).
            if ($isList) {
                continue;
            }

            // If the value is a specification extension, then skip the null
            // check below.
            if (is_string($index) && Extension::isExtension($index)) {
                continue;
            }

            // If the value is null, then remove it.
            if (is_null($value)) {
                unset($array[$index]);
            }
        }

        return $array;
    }
}
