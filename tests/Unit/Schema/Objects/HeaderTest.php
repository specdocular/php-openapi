<?php

namespace Tests\Unit\Schema\Objects;

use Specdocular\OpenAPI\Schema\Objects\Example\Example;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\Content;
use Specdocular\OpenAPI\Support\Serialization\HeaderParameter;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Specdocular\OpenAPI\Support\SharedFields\Examples\ExampleEntry;
use Specdocular\OpenAPI\Support\Style\Styles\Simple;
use Webmozart\Assert\InvalidArgumentException;

describe(class_basename(Header::class), function (): void {
    it('can be created with schema-based serialization', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::object(), Simple::create()->explode()),
        )->description('Lorem ipsum')
            ->required()
            ->deprecated()
            ->examples(
                ExampleEntry::create(
                    'ExampleName',
                    Example::create(),
                ),
            );

        expect($header->compile())->toBe([
            'description' => 'Lorem ipsum',
            'required' => true,
            'deprecated' => true,
            'style' => 'simple',
            'explode' => true,
            'schema' => [
                'type' => 'object',
            ],
            'examples' => [
                'ExampleName' => [],
            ],
        ]);
    });

    it('can be created with content-based serialization', function (): void {
        $header = Header::create(
            Content::create(
                ContentEntry::json(
                    MediaType::create(),
                ),
            ),
        )->description('Lorem ipsum');

        expect($header->compile())->toBe([
            'description' => 'Lorem ipsum',
            'content' => [
                'application/json' => [],
            ],
        ]);
    });

    it('can be created with singular example', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::string()),
        )->example('Bearer token123');

        expect($header->compile())->toBe([
            'schema' => [
                'type' => 'string',
            ],
            'example' => 'Bearer token123',
        ]);
    });

    it('can be created with complex example value', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::integer()),
        )->example(42);

        expect($header->compile())->toBe([
            'schema' => [
                'type' => 'integer',
            ],
            'example' => 42,
        ]);
    });

    it('throws exception when setting example after examples', function (): void {
        $header = Header::create()
            ->examples(
                ExampleEntry::create('ExampleName', Example::create()),
            );

        expect(fn () => $header->example('test'))
            ->toThrow(InvalidArgumentException::class, 'example and examples fields are mutually exclusive.');
    });

    it('throws exception when setting examples after example', function (): void {
        $header = Header::create()
            ->example('test value');

        expect(fn () => $header->examples(
            ExampleEntry::create('ExampleName', Example::create()),
        ))->toThrow(InvalidArgumentException::class, 'examples and example fields are mutually exclusive.');
    });

    it('can be created with allowReserved (OAS 3.2)', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::string())->allowReserved(),
        );

        expect($header->compile())->toBe([
            'allowReserved' => true,
            'schema' => [
                'type' => 'string',
            ],
        ]);
    });

    it('can be created with style and allowReserved (OAS 3.2)', function (): void {
        $header = Header::create(
            HeaderParameter::create(Schema::array(), Simple::create()->explode())->allowReserved(),
        );

        expect($header->compile())->toBe([
            'style' => 'simple',
            'explode' => true,
            'allowReserved' => true,
            'schema' => [
                'type' => 'array',
            ],
        ]);
    });

    it('can be created without serialization rule', function (): void {
        $header = Header::create()
            ->description('A simple header')
            ->required();

        expect($header->compile())->toBe([
            'description' => 'A simple header',
            'required' => true,
        ]);
    });

    it('can use example with content-based serialization', function (): void {
        $header = Header::create(
            Content::create(
                ContentEntry::json(MediaType::create()),
            ),
        )->example('some-value');

        expect($header->compile())->toBe([
            'content' => [
                'application/json' => [],
            ],
            'example' => 'some-value',
        ]);
    });

    it('can use examples with content-based serialization', function (): void {
        $header = Header::create(
            Content::create(
                ContentEntry::json(MediaType::create()),
            ),
        )->examples(
            ExampleEntry::create('first', Example::create()->value('a')),
            ExampleEntry::create('second', Example::create()->value('b')),
        );

        expect($header->compile())->toBe([
            'content' => [
                'application/json' => [],
            ],
            'examples' => [
                'first' => ['value' => 'a'],
                'second' => ['value' => 'b'],
            ],
        ]);
    });
})->covers(Header::class);
