<?php

namespace Specdocular\OpenAPI\Contracts\Abstract;

use Specdocular\OpenAPI\Contracts\Interface\MergeableFields;

trait Generator
{
    /**
     * Saves the object as a JSON file.
     *
     * @param string|null $path path without trailing slash. If null, the file will be saved in the root directory.
     * @param string $name the name of the file
     */
    public function toJsonFile(
        string $name,
        string|null $path = null,
        int $options = JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
    ): bool|int {
        if (!is_null($path) && '' !== $path && '0' !== $path) {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            return file_put_contents(
                $path . sprintf('/%s.json', $name),
                $this->toJson($options),
            );
        }

        return file_put_contents(
            $name . '.json',
            $this->toJson($options),
        );
    }

    public function toJson(
        int $options = JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
    ): string {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * It should not be used directly.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract public function toArray(): array;

    /**
     * Compiles the object to an associative array.
     *
     * Empty object-positions (an empty Schema Object, an empty `paths`/`components`
     * container marked via {@see self::toObjectIfEmpty()}) survive as `\stdClass` so a
     * subsequent json_encode() renders `{}`, not `[]`. A plain `json_decode(…, true)`
     * would flatten both onto the same PHP `[]`, losing the OAS object-vs-array
     * distinction; decoding as objects and re-arrayifying preserves it.
     *
     * @throws \JsonException
     */
    public function compile(): array
    {
        $decoded = json_decode($this->toJson(), false, 512, JSON_THROW_ON_ERROR);
        $result = self::preserveEmptyObjects($decoded);

        return is_array($result) ? $result : (array) $result;
    }

    private static function preserveEmptyObjects(mixed $value): mixed
    {
        if ($value instanceof \stdClass) {
            $properties = get_object_vars($value);

            return [] === $properties
                ? $value
                : array_map([self::class, 'preserveEmptyObjects'], $properties);
        }

        if (is_array($value)) {
            return array_map([self::class, 'preserveEmptyObjects'], $value);
        }

        return $value;
    }

    public function toObjectIfEmpty(
        Generatable|ReadonlyGeneratable|array|null $value,
    ): Generatable|ReadonlyGeneratable|\stdClass {
        $orgValue = $value;
        if ($value instanceof Generatable || $value instanceof ReadonlyGeneratable) {
            $value = $value->toArray();
        }

        if (blank($value)) {
            return new \stdClass();
        }

        return $orgValue;
    }

    public function toNullIfEmpty(): static|null
    {
        return blank($this->toArray()) ? null : $this;
    }

    /**
     * Returns an array of fields from a MergeableFields object for spreading into toArray().
     *
     * Use this method when a child object's fields should appear at the same level
     * as the parent's fields in the OpenAPI specification output.
     *
     * @return array<string, mixed>
     */
    protected function mergeFields(MergeableFields|null $fields): array
    {
        return $fields?->jsonSerialize() ?? [];
    }
}
