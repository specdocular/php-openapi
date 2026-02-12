<?php

namespace Specdocular\OpenAPI\Schema\Objects\Server;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\URL;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables\VariableEntry;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables\Variables;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;
use Specdocular\OpenAPI\Support\SharedFields\Name;

/**
 * Server Object.
 *
 * An object representing a Server. The url field is required.
 * Server variables can be used for variable substitution in the URL.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#server-object
 */
final class Server extends ExtensibleObject
{
    private Name|null $name = null;
    private Description|null $description = null;
    private Variables|null $variables = null;

    private function __construct(
        private readonly URL $url,
    ) {
    }

    public static function default(): self
    {
        return self::create('/');
    }

    public static function create(string $url): self
    {
        return new self(URL::create($url));
    }

    /**
     * A human-readable name for the server.
     *
     * Useful when multiple servers are defined for identification purposes.
     */
    public function name(string $name): self
    {
        $clone = clone $this;

        $clone->name = Name::create($name);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    public function variables(VariableEntry ...$variableEntry): self
    {
        $clone = clone $this;

        $clone->variables = Variables::create(...$variableEntry);

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter([
            'url' => $this->url,
            'name' => $this->name,
            'description' => $this->description,
            'variables' => $this->variables,
        ]);
    }
}
