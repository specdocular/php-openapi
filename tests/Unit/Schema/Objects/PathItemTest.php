<?php

namespace Tests\Unit\Schema\Objects;

use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AdditionalOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;

describe(class_basename(PathItem::class), function (): void {
    it('can be created with all parameters', function (): void {
        $paths = Paths::create(
            Path::create(
                '/users',
                PathItem::create()
                    ->summary('User endpoints')
                    ->description('Get the users')
                    ->operations(
                        AvailableOperation::create(
                            HttpMethod::GET,
                            Operation::create()
                                ->operationId('getUsers')
                                ->responses(
                                    Responses::create(
                                        ResponseEntry::create(
                                            HTTPStatusCode::ok(),
                                            Response::create()->description('OK'),
                                        ),
                                    ),
                                ),
                        ),
                    )
                    ->servers(Server::create('https://laragen.io'))
                    ->parameters(
                        Parameters::create(
                            Parameter::query(
                                'test_parameter',
                                QueryParameter::create(Schema::string()),
                            ),
                        ),
                    ),
            ),
        );

        expect($paths->compile())->toBe([
            '/users' => [
                'summary' => 'User endpoints',
                'description' => 'Get the users',
                'get' => [
                    'operationId' => 'getUsers',
                    'responses' => [
                        '200' => [
                            'description' => 'OK',
                        ],
                    ],
                ],
                'servers' => [
                    ['url' => 'https://laragen.io'],
                ],
                'parameters' => [
                    [
                        'name' => 'test_parameter',
                        'in' => 'query',
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
        ]);
    });

    it('can be created with $ref', function (): void {
        $pathItem = PathItem::create()
            ->ref('#/components/pathItems/UserPath');

        expect($pathItem->compile())->toBe([
            '$ref' => '#/components/pathItems/UserPath',
        ]);
    });

    it('can combine $ref with other fields', function (): void {
        $pathItem = PathItem::create()
            ->ref('#/components/pathItems/UserPath')
            ->summary('User operations')
            ->description('Operations on user resource');

        expect($pathItem->compile())->toBe([
            '$ref' => '#/components/pathItems/UserPath',
            'summary' => 'User operations',
            'description' => 'Operations on user resource',
        ]);
    });

    it('can use external $ref', function (): void {
        $pathItem = PathItem::create()
            ->ref('https://example.com/openapi.yaml#/components/pathItems/UserPath');

        expect($pathItem->compile())->toBe([
            '$ref' => 'https://example.com/openapi.yaml#/components/pathItems/UserPath',
        ]);
    });

    it('can create with QUERY http method (OAS 3.2)', function (): void {
        $pathItem = PathItem::create()
            ->operations(
                AvailableOperation::create(
                    HttpMethod::QUERY,
                    Operation::create()
                        ->operationId('searchUsers')
                        ->responses(
                            Responses::create(
                                ResponseEntry::create(
                                    HTTPStatusCode::ok(),
                                    Response::create()->description('Search results'),
                                ),
                            ),
                        ),
                ),
            );

        expect($pathItem->compile())->toBe([
            'query' => [
                'operationId' => 'searchUsers',
                'responses' => [
                    '200' => [
                        'description' => 'Search results',
                    ],
                ],
            ],
        ]);
    });

    it('can create with additionalOperations for custom HTTP methods (OAS 3.2)', function (): void {
        $pathItem = PathItem::create()
            ->additionalOperations(
                AdditionalOperation::create(
                    'CUSTOM',
                    Operation::create()
                        ->operationId('customOperation')
                        ->responses(
                            Responses::create(
                                ResponseEntry::create(
                                    HTTPStatusCode::ok(),
                                    Response::create()->description('Custom response'),
                                ),
                            ),
                        ),
                ),
            );

        expect($pathItem->compile())->toBe([
            'additionalOperations' => [
                'CUSTOM' => [
                    'operationId' => 'customOperation',
                    'responses' => [
                        '200' => [
                            'description' => 'Custom response',
                        ],
                    ],
                ],
            ],
        ]);
    });

    it('can combine standard operations with additionalOperations (OAS 3.2)', function (): void {
        $pathItem = PathItem::create()
            ->operations(
                AvailableOperation::create(
                    HttpMethod::GET,
                    Operation::create()
                        ->operationId('getResource')
                        ->responses(
                            Responses::create(
                                ResponseEntry::create(
                                    HTTPStatusCode::ok(),
                                    Response::create()->description('OK'),
                                ),
                            ),
                        ),
                ),
            )
            ->additionalOperations(
                AdditionalOperation::create(
                    'SUBSCRIBE',
                    Operation::create()
                        ->operationId('subscribeResource')
                        ->responses(
                            Responses::create(
                                ResponseEntry::create(
                                    HTTPStatusCode::ok(),
                                    Response::create()->description('Subscribed'),
                                ),
                            ),
                        ),
                ),
            );

        $result = $pathItem->compile();

        expect($result)->toHaveKeys(['get', 'additionalOperations'])
            ->and($result['get']['operationId'])->toBe('getResource')
            ->and($result['additionalOperations']['SUBSCRIBE']['operationId'])->toBe('subscribeResource');
    });
})->covers(PathItem::class);
