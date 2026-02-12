<?php

use Specdocular\JsonSchema\Draft202012\Formats\StringFormat;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Schema\Objects\Components\Components;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Schema\Objects\Security\Security;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Tests\Support\Factories\Security\SecurityRequirements\TestBearerSecurityRequirementFactory;
use Tests\Support\Factories\Security\SecuritySchemes\TestBearerSecuritySchemeFactory;

describe('OpenApi', function (): void {
    it('can generate valid OpenAPI v3.1.0 docs', function (): void {
        $tag = Tag::create('Audits')->description('All the audits');
        $contact = Contact::create()
            ->name('Example')
            ->url('https://laragen.io')
            ->email('hello@laragen.io');
        $info = Info::create('API Specification', 'v1')
            ->description('For using the Example App API')
            ->contact($contact)
            ->license(
                License::create('MIT')->url('https://github.com/laragen'),
            );
        $schema = Schema::object()
            ->properties(
                Property::create('id', Schema::string()->format(StringFormat::UUID)),
                Property::create('created_at', Schema::string()->format(StringFormat::DATE_TIME)),
                Property::create('age', Schema::integer()->examples(60)),
                Property::create(
                    'data',
                    Schema::array()->items(
                        Schema::allOf(
                            Schema::string()->format(StringFormat::UUID),
                        ),
                    ),
                ),
            )->required('id', 'created_at');
        $responses = Responses::create(
            ResponseEntry::create(
                HTTPStatusCode::ok(),
                Response::create()->description('OK')
                    ->content(
                        ContentEntry::json(
                            MediaType::create()->schema($schema),
                        ),
                    ),
            ),
            ResponseEntry::create(
                HTTPStatusCode::unprocessableEntity(),
                Response::create()->description('Unprocessable Entity')
                    ->content(
                        ContentEntry::json(
                            MediaType::create()->schema($schema),
                        ),
                    ),
            ),
        );
        $indexOperation = Operation::create()
            ->responses($responses)
            ->tags($tag)
            ->summary('List all audits')
            ->operationId('audits.index');
        $postOperation = Operation::create()
            ->responses($responses)
            ->tags($tag)
            ->summary('Create an audit')
            ->operationId('audits.store')
            ->requestBody(
                RequestBody::create(
                    ContentEntry::json(
                        MediaType::create()->schema($schema),
                    ),
                ),
            );
        $stringDescriptor = Schema::string()->format(StringFormat::UUID);
        $enumDescriptor = Schema::enum('json', 'ics')
            ->default('json');
        $getOperation = Operation::create()
            ->responses($responses)
            ->tags($tag)
            ->summary('View an audit')
            ->operationId('audits.show')
            ->parameters(
                Parameters::create(
                    Parameter::path(
                        'audit',
                        PathParameter::create($stringDescriptor),
                    )->required(),
                    Parameter::query(
                        'format',
                        QueryParameter::create($enumDescriptor),
                    )->description('The format of the appointments'),
                ),
            );
        $paths = Paths::create(
            Path::create(
                '/audits',
                PathItem::create()
                    ->operations(
                        AvailableOperation::create(
                            HttpMethod::GET,
                            $indexOperation,
                        ),
                        AvailableOperation::create(
                            HttpMethod::POST,
                            $postOperation,
                        ),
                    ),
            ),
            Path::create(
                '/audits/{audit}',
                PathItem::create()
                    ->operations(
                        AvailableOperation::create(
                            HttpMethod::GET,
                            $getOperation,
                        ),
                    ),
            ),
        );
        $servers = [
            Server::create('https://api.laragen.io/v1'),
            Server::create('https://api.laragen.io/v2'),
        ];
        $components = Components::create()->securitySchemes(TestBearerSecuritySchemeFactory::create());
        $security = Security::create(TestBearerSecurityRequirementFactory::create());
        $externalDocumentation = ExternalDocumentation::create('https://laragen.io/docs')
            ->description(
                'Example',
            );
        $openApi = OpenAPI::v311($info)
            ->paths($paths)
            ->servers(...$servers)
            ->components($components)
            ->security($security)
            ->tags($tag)
            ->externalDocs($externalDocumentation);

        $openApi->toJsonFile('openapi', options: JSON_PRETTY_PRINT);

        expect('openapi.json')->toBeValidJsonSchema();
    })->after(function () {
        @unlink('openapi.json');
    });
})->coversNothing();
