<?php

use Specdocular\OpenAPI\Schema\Objects\ExternalDocumentation\ExternalDocumentation;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\Tag\Tag;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Tests\Support\Doubles\Stubs\Attributes\TestCallbackFactory;
use Tests\Support\Factories\Security\SecuritySchemes\TestBearerSecuritySchemeFactory;
use Tests\Support\Factories\Security\TestSingleHTTPBearerSchemeSecurityFactory;

describe(class_basename(Operation::class), function (): void {
    it('can be created with no parameters', function (): void {
        $operation = Operation::create();

        expect($operation->compile())->toHaveCount(1)
        ->toHaveKey('operationId');
    });

    it(
        'can can be created with all parameters',
        function (): void {
            $operation = Operation::create()
                ->tags(
                    Tag::create('Users')->description('Lorem ipsum'),
                    Tag::create('Admins'),
                )->summary('Lorem ipsum')
                ->description('Dolar sit amet')
                ->externalDocs(ExternalDocumentation::create('https://laragen.io/docs'))
                ->operationId('users.show')
                ->parameters(
                    Parameters::create(
                        Parameter::query(
                            'id',
                            QueryParameter::create(Schema::string()),
                        ),
                    ),
                )->requestBody(RequestBody::create(ContentEntry::json(MediaType::create())))
                ->responses(
                    Responses::create(
                        ResponseEntry::create(
                            HTTPStatusCode::ok(),
                            Response::create()->description('OK'),
                        ),
                    ),
                )->deprecated()
                ->security((new TestSingleHTTPBearerSchemeSecurityFactory())->build())
                ->servers(Server::default())
                ->callbacks(TestCallbackFactory::create());

            expect($operation->compile())->toBe([
                'tags' => ['Users', 'Admins'],
                'summary' => 'Lorem ipsum',
                'description' => 'Dolar sit amet',
                'externalDocs' => [
                    'url' => 'https://laragen.io/docs',
                ],
                'operationId' => 'users.show',
                'parameters' => [
                    [
                        'name' => 'id',
                        'in' => 'query',
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ],
                'requestBody' => [
                    'content' => [
                        'application/json' => [],
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                    ],
                ],
                'deprecated' => true,
                'security' => [
                    [
                        TestBearerSecuritySchemeFactory::name() => [],
                    ],
                ],
                'servers' => [
                    [
                        'url' => '/',
                    ],
                ],
                'callbacks' => [
                    'TestCallbackFactory' => [
                        'https://laragen.io/' => [],
                    ],
                ],
            ]);
        },
    );
})->covers(Operation::class);
