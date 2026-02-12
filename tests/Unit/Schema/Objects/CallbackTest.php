<?php

use Specdocular\OpenAPI\Schema\Objects\Callback\Callback;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Support\RuntimeExpression\Request\RequestQueryExpression;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;

describe(class_basename(Callback::class), function (): void {
    it(
        'can be created',
        function (HttpMethod $method): void {
            $callback = Callback::create(
                RequestQueryExpression::create('callbackUrl'),
                PathItem::create()
                    ->operations(
                        AvailableOperation::create(
                            $method,
                            Operation::create()
                                ->operationId('myEvent')
                                ->requestBody(
                                    RequestBody::create(ContentEntry::json(MediaType::create()))
                                        ->description(
                                            'something happened',
                                        ),
                                )->responses(
                                    Responses::create(
                                        ResponseEntry::create(
                                            HTTPStatusCode::unauthorized(),
                                            Response::create()->description('Unauthorized'),
                                        ),
                                    ),
                                ),
                        ),
                    ),
                'MyEvent',
            );

            expect($callback)->compile()->toHaveKey(
                '{$request.query.callbackUrl}',
                [
                    $method->value => [
                        'requestBody' => [
                            'description' => 'something happened',
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                        'responses' => [
                            401 => [
                                'description' => 'Unauthorized',
                            ],
                        ],
                        'operationId' => 'myEvent',
                    ],
                ],
            )->name()->toBe('MyEvent');
        },
    )->with([
        'get action' => [HttpMethod::GET],
        'put action' => [HttpMethod::PUT],
        'post action' => [HttpMethod::POST],
        'delete action' => [HttpMethod::DELETE],
        'options action' => [HttpMethod::OPTIONS],
        'head action' => [HttpMethod::HEAD],
        'patch action' => [HttpMethod::PATCH],
        'trace action' => [HttpMethod::TRACE],
    ]);
})->covers(Callback::class);
