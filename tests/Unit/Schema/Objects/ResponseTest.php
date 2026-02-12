<?php

use Specdocular\OpenAPI\Schema\Objects\Example\Example;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;
use Specdocular\OpenAPI\Schema\Objects\Link\Link;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\Content;
use Specdocular\OpenAPI\Support\Serialization\HeaderParameter;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Specdocular\OpenAPI\Support\SharedFields\Examples\ExampleEntry;
use Specdocular\OpenAPI\Support\SharedFields\Headers\HeaderEntry;
use Specdocular\OpenAPI\Support\SharedFields\Links\LinkEntry;

describe('Response', function (): void {
    it('creates a response with all parameters', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::string()),
        )->description('Lorem ipsum')
            ->required()
            ->deprecated()
            ->examples(
                ExampleEntry::create(
                    'ExampleName',
                    Example::create()
                        ->value('Example value'),
                ),
            );

        $link = Link::create();

        $response = Response::create()
            ->description('A response indicating success')
            ->headers(
                HeaderEntry::create(
                    'HeaderName',
                    $header,
                ),
            )->content(
                ContentEntry::json(
                    MediaType::create(),
                ),
            )->links(
                LinkEntry::create('MyLink', $link),
            );

        expect($response->compile())->toBe([
            'description' => 'A response indicating success',
            'headers' => [
                'HeaderName' => [
                    'description' => 'Lorem ipsum',
                    'required' => true,
                    'deprecated' => true,
                    'schema' => [
                        'type' => 'string',
                    ],
                    'examples' => [
                        'ExampleName' => [
                            'value' => 'Example value',
                        ],
                    ],
                ],
            ],
            'content' => [
                'application/json' => [],
            ],
            'links' => [
                'MyLink' => [],
            ],
        ]);
    });

    it('creates a response with content-based header', function (): void {
        $header = Header::create(
            Content::create(
                ContentEntry::json(
                    MediaType::create(),
                ),
            ),
        )->description('Lorem ipsum')
            ->required();

        $response = Response::create()
            ->description('A response indicating success')
            ->headers(
                HeaderEntry::create(
                    'HeaderName',
                    $header,
                ),
            );

        expect($response->compile())->toBe([
            'description' => 'A response indicating success',
            'headers' => [
                'HeaderName' => [
                    'description' => 'Lorem ipsum',
                    'required' => true,
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
        ]);
    });
    it('can set summary field', function (): void {
        $response = Response::create()
            ->description('OK')
            ->summary('Successful operation');

        expect($response->compile())->toBe([
            'description' => 'OK',
            'summary' => 'Successful operation',
        ]);
    });

    it('can set summary with other fields', function (): void {
        $response = Response::create()
            ->description('OK')
            ->summary('Successful operation')
            ->content(
                ContentEntry::json(
                    MediaType::create(),
                ),
            );

        expect($response->compile())->toBe([
            'description' => 'OK',
            'summary' => 'Successful operation',
            'content' => [
                'application/json' => [],
            ],
        ]);
    });
})->covers(Response::class);
