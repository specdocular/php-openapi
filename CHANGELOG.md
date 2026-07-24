# Changelog

All notable changes to PHP OpenAPI are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] - 2026-02-13

Initial release — an object-oriented OpenAPI 3.1.x builder for PHP.

### Added

- Fluent, chainable API for all OpenAPI 3.1.x objects (Paths, Operations, Schemas,
  Responses, Request Bodies, Parameters, Security Schemes, and more).
- Automatic component reference collection and management.
- Framework-agnostic design with no dependency on Laravel or any framework.
- Built on [specdocular/php-json-schema](https://github.com/specdocular/php-json-schema)
  for schema definitions.

[Unreleased]: https://github.com/specdocular/php-openapi/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/specdocular/php-openapi/releases/tag/v0.1.0
