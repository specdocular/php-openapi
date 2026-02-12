<?php

namespace Specdocular\OpenAPI\Schema\Objects\PathItem;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Fields\Ref;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AdditionalOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AdditionalOperations;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\Operations;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Specdocular\OpenAPI\Support\SharedFields\Summary;

/**
 * Path Item Object.
 *
 * Describes the operations available on a single path. A Path Item MAY be
 * empty due to ACL constraints. The path itself is still exposed to the
 * documentation viewer but they will not know which operations are available.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#path-item-object
 */
final class PathItem extends ExtensibleObject
{
    private Ref|null $ref = null;
    private Summary|null $summary = null;
    private Description|null $description = null;
    private Operations|null $operations = null;
    private AdditionalOperations|null $additionalOperations = null;

    /** @var Server[]|null */
    private array|null $servers = null;

    private Parameters|null $parameters = null;

    public function summary(string $summary): self
    {
        $clone = clone $this;

        $clone->summary = Summary::create($summary);

        return $clone;
    }

    public static function create(): self
    {
        return new self();
    }

    /**
     * Allows for a referenced definition of this path item.
     *
     * The referenced structure MUST be a Path Item Object. In case a Path Item
     * Object field appears both in the defined object and the referenced object,
     * the behavior is undefined.
     *
     * @param string $ref A reference to a Path Item Object (e.g., "#/components/pathItems/...")
     */
    public function ref(string $ref): self
    {
        $clone = clone $this;

        $clone->ref = Ref::create($ref);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    public function operations(AvailableOperation ...$availableOperation): self
    {
        $clone = clone $this;

        $clone->operations = Operations::create(...$availableOperation);

        return $clone;
    }

    public function getOperations(): Operations|null
    {
        return $this->operations;
    }

    /**
     * Additional operations for custom HTTP methods.
     *
     * Use this for HTTP methods beyond the standard ones (get, post, put, etc.).
     */
    public function additionalOperations(AdditionalOperation ...$additionalOperation): self
    {
        $clone = clone $this;

        $clone->additionalOperations = AdditionalOperations::create(...$additionalOperation);

        return $clone;
    }

    public function servers(Server ...$server): self
    {
        $clone = clone $this;

        $clone->servers = blank($server) ? null : $server;

        return $clone;
    }

    public function parameters(Parameters $parameters): self
    {
        $clone = clone $this;

        $clone->parameters = $parameters->toNullIfEmpty();

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter(
            [
                '$ref' => $this->ref,
                'summary' => $this->summary,
                'description' => $this->description,
                ...$this->mergeFields($this->operations),
                'additionalOperations' => $this->additionalOperations,
                'servers' => $this->servers,
                'parameters' => $this->parameters,
            ],
        );
    }
}
