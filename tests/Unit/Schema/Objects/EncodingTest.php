<?php

namespace Tests\Unit\Schema\Objects;

use Specdocular\OpenAPI\Schema\Objects\Encoding\Encoding;
use Specdocular\OpenAPI\Schema\Objects\Example\Example;
use Specdocular\OpenAPI\Schema\Objects\Header\Header;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Support\Serialization\HeaderParameter;
use Specdocular\OpenAPI\Support\SharedFields\Encodings\EncodingEntry;
use Specdocular\OpenAPI\Support\SharedFields\Examples\ExampleEntry;
use Specdocular\OpenAPI\Support\SharedFields\Headers\HeaderEntry;

describe(class_basename(Encoding::class), function (): void {
    it('can be created with all parameters', function (): void {
        $header = HeaderEntry::create(
            'HeaderName',
            Header::create(
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
                ),
        );

        $encoding = EncodingEntry::create(
            'EncodingName',
            Encoding::create()
                ->contentType('application/json')
                ->headers($header)
                ->style('simple')
                ->explode()
                ->allowReserved(),
        );

        $mediaType = MediaType::create()
            ->encoding($encoding);

        expect($mediaType->compile())->toBe([
            'encoding' => [
                'EncodingName' => [
                    'contentType' => 'application/json',
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
                    'style' => 'simple',
                    'explode' => true,
                    'allowReserved' => true,
                ],
            ],
        ]);
    });
    it('can explicitly set explode to false', function (): void {
        $encoding = Encoding::create()
            ->style('form')
            ->explode(false);

        expect($encoding->compile())->toBe([
            'style' => 'form',
            'explode' => false,
        ]);
    });
    it('can have nested encoding map (OAS 3.2)', function (): void {
        $encoding = Encoding::create()
            ->contentType('multipart/mixed')
            ->encoding(
                EncodingEntry::create(
                    'nestedProp',
                    Encoding::create()->contentType('application/json'),
                ),
            );

        expect($encoding->compile())->toBe([
            'contentType' => 'multipart/mixed',
            'encoding' => [
                'nestedProp' => ['contentType' => 'application/json'],
            ],
        ]);
    });

    it('can have prefixEncoding for positional encoding (OAS 3.2)', function (): void {
        $encoding = Encoding::create()
            ->contentType('multipart/mixed')
            ->prefixEncoding(
                Encoding::create()->contentType('image/png'),
                Encoding::create()->contentType('text/plain'),
            );

        expect($encoding->compile())->toBe([
            'contentType' => 'multipart/mixed',
            'prefixEncoding' => [
                ['contentType' => 'image/png'],
                ['contentType' => 'text/plain'],
            ],
        ]);
    });

    it('can have itemEncoding for array items (OAS 3.2)', function (): void {
        $encoding = Encoding::create()
            ->contentType('multipart/mixed')
            ->itemEncoding(
                Encoding::create()->contentType('application/octet-stream'),
            );

        expect($encoding->compile())->toBe([
            'contentType' => 'multipart/mixed',
            'itemEncoding' => [
                'contentType' => 'application/octet-stream',
            ],
        ]);
    });
})->covers(Encoding::class);
