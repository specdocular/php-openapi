<?php

use Pest\Expectation;

if (!function_exists('class_basename')) {
    function class_basename(string|object $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

expect()->extend('toBeImmutable', function (): void {
    $reflection = new ReflectionClass($this->value);

    expect($reflection->isReadOnly())->toBeTrue(
        'The class ' . $this->value . ' is not immutable.',
    );
});

expect()->extend(
    'toBeValidJsonSchema',
    function (): void {
        exec(
            "npx redocly lint --format stylish --extends recommended-strict $this->value 2>&1",
            $output,
            $result_code,
        );
        $this->when(
            $result_code,
            function (Expectation $expectation) use ($output): Expectation {
                return $expectation->toBeEmpty(implode("\n", $output));
            },
        );
    },
);
