# PHP OpenAPI

[![Tests](https://github.com/specdocular/php-openapi/actions/workflows/tests.yml/badge.svg)](https://github.com/specdocular/php-openapi/actions/workflows/tests.yml)
[![Code Style](https://github.com/specdocular/php-openapi/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/specdocular/php-openapi/actions/workflows/php-cs-fixer.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/specdocular/php-openapi.svg)](https://packagist.org/packages/specdocular/php-openapi)
[![PHP Version](https://img.shields.io/packagist/php-v/specdocular/php-openapi.svg)](https://packagist.org/packages/specdocular/php-openapi)
[![License](https://img.shields.io/packagist/l/specdocular/php-openapi.svg)](https://packagist.org/packages/specdocular/php-openapi)

An object-oriented [OpenAPI 3.1.x](https://spec.openapis.org/oas/v3.1.1.html) builder for PHP. Build complete API specifications with a fluent, chainable API that hides the complexity of the OpenAPI specification.

## Installation

```bash
composer require specdocular/php-openapi
```

## Usage

```php
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;

$openApi = OpenAPI::v311(
    Info::create('Pet Store', '1.0.0')
        ->description('A sample Pet Store API')
);

// Define schemas
$petSchema = Schema::object()
    ->properties(
        Property::create('id', Schema::string()->format('uuid')),
        Property::create('name', Schema::string()),
    )
    ->required('id', 'name');

// Export as JSON
$json = json_encode($openApi, JSON_PRETTY_PRINT);
```

## Features

- Fluent, chainable API for all OpenAPI 3.1.x objects
- Full support for Paths, Operations, Schemas, Responses, Request Bodies, Parameters, Security Schemes, and more
- Automatic component reference collection and management
- Built on [specdocular/php-json-schema](https://github.com/specdocular/php-json-schema) for schema definitions
- Framework-agnostic — no dependencies on Laravel or any framework

## Related Packages

| Package | Description |
|---------|-------------|
| [specdocular/php-json-schema](https://github.com/specdocular/php-json-schema) | JSON Schema Draft 2020-12 builder (foundation) |
| [specdocular/laravel-openapi](https://github.com/specdocular/laravel-openapi) | Laravel integration for OpenAPI generation (uses this package) |
| [specdocular/laravel-rules-to-schema](https://github.com/specdocular/laravel-rules-to-schema) | Convert Laravel validation rules to JSON Schema |

## License

MIT. See [LICENSE](LICENSE) for details.
