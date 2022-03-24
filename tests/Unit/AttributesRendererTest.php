<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\AttributesRenderer;

it('renders', function (): void {
    $attributes = [
        'boolean',
        'boolean-false' => false,
        'boolean-true' => true,
        'class' => 'yellow',
        'x-init' => 'foo = "qux"',
    ];

    $result = AttributesRenderer::render($attributes);

    expect($result)->toEqual(
        'boolean boolean-false="0" boolean-true class="yellow" x-init="foo = &quot;qux&quot;"',
    );
});

it('renders with callbacks', function (): void {
    $attributes = [
        'class' => 'yellow',
        'x-data' => ['foo' => 'bar'],
    ];

    $result = AttributesRenderer::render($attributes, [
        fn ($value) => $value === 'yellow' ? 'blue' : $value,

        fn ($value, $key) => $key === 'x-data' && is_array($value)
            ? json_encode($value, JSON_THROW_ON_ERROR)
            : $value,
    ]);

    expect($result)->toEqual(
        'class="blue" x-data="{&quot;foo&quot;:&quot;bar&quot;}"',
    );
});
