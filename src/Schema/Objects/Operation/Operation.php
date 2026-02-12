<?php

namespace Specdocular\OpenAPI\Schema\Objects\Operation;

use Specdocular\OpenAPI\Contracts\Abstract\ExtensibleObject;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\CallbackFactory;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\RequestBodyFactory;
use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Specdocular\OpenAPI\Schema\Objects\Operation\Fields\OperationId;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;
use Specdocular\OpenAPI\Support\Arr;
use Specdocular\OpenAPI\Support\SharedFields\Description;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Specdocular\OpenAPI\Support\SharedFields\Summary;

/**
 * Operation Object.
 *
 * Describes a single API operation on a path. An Operation Object is
 * required for each HTTP method on a path that the API exposes.
 *
 * @see https://spec.openapis.org/oas/v3.2.0#operation-object
 */
final class Operation extends ExtensibleObject
{
    private Summary|null $summary = null;
    private Description|null $description = null;
    private ExternalDocumentation|null $externalDocs = null;
    private OperationId|null $operationId = null;
    private Parameters|null $parameters = null;
    private RequestBody|RequestBodyFactory|null $requestBody = null;
    private Responses|null $responses = null;
    private Security|null $security = null;
    private true|null $deprecated = null;

    /** @var string[]|null */
    private array|null $tags = null;

    /** @var Server[]|null */
    private array|null $servers = null;

    /** @var Callback|CallbackFactory[]|null */
    private array|null $callbacks = null;

    public function tags(Tag ...$tag): self
    {
        $tags = array_map(
            static function (Tag $tag): string {
                return $tag->name();
            },
            $tag,
        );

        $clone = clone $this;

        $clone->tags = blank($tags) ? null : $tags;

        return $clone;
    }

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

    public function description(string $description): self
    {
        $clone = clone $this;

        $clone->description = Description::create($description);

        return $clone;
    }

    public function externalDocs(ExternalDocumentation $externalDocs): self
    {
        $clone = clone $this;

        $clone->externalDocs = $externalDocs;

        return $clone;
    }

    public function operationId(string $operationId): self
    {
        $clone = clone $this;

        $clone->operationId = OperationId::create($operationId);

        return $clone;
    }

    public function parameters(Parameters $parameters): self
    {
        $clone = clone $this;

        $clone->parameters = $parameters->toNullIfEmpty();

        return $clone;
    }

    public function requestBody(RequestBody|RequestBodyFactory $requestBody): self
    {
        $clone = clone $this;

        $clone->requestBody = $requestBody;

        return $clone;
    }

    public function responses(Responses $responses): self
    {
        $clone = clone $this;

        $clone->responses = $responses;

        return $clone;
    }

    public function deprecated(): self
    {
        $clone = clone $this;

        $clone->deprecated = true;

        return $clone;
    }

    public function security(Security $security): self
    {
        $clone = clone $this;

        $clone->security = $security;

        return $clone;
    }

    public function servers(Server ...$server): self
    {
        $clone = clone $this;

        $clone->servers = blank($server) ? null : $server;

        return $clone;
    }

    public function callbacks(Callback|CallbackFactory ...$callback): self
    {
        $clone = clone $this;

        foreach ($callback as $item) {
            if ($item instanceof CallbackFactory) {
                $clone->callbacks[$item::name()] = $item;
            }

            if ($item instanceof Callback) {
                $clone->callbacks[$item->name()] = $item;
            }
        }

        return $clone;
    }

    public function toArray(): array
    {
        return Arr::filter([
            'tags' => $this->tags,
            'summary' => $this->summary,
            'description' => $this->description,
            'externalDocs' => $this->externalDocs,
            'operationId' => $this->operationId ?? OperationId::create(uniqid('', true)),
            'parameters' => $this->parameters,
            'requestBody' => $this->requestBody,
            'responses' => $this->responses,
            'deprecated' => $this->deprecated,
            'security' => $this->security,
            'servers' => $this->servers,
            'callbacks' => $this->callbacks,
        ]);
    }
}
