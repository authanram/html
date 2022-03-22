<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Attributes;

beforeEach(function () {
    $this->attributes = [
        'quux' => false,
        'foo' => 'bar',
        'bar' => 'foo bar baz',
        'baz',
        'data-foo' => true,
    ];

    $this->instance = Attributes::make($this->attributes);
});

it('can be instantiated', function (): void {
    expect((new Attributes())->toArray())
        ->toEqual([]);

    expect((new Attributes($this->attributes))->getAttributes())
        ->toEqual($this->attributes);
});

it('can be instantiated statically', function (): void {
    expect(Attributes::make()->getAttributes())
        ->toEqual([]);

    expect($this->instance->getAttributes())
        ->toEqual($this->attributes);
});

it('gets attributes', function (): void {
    expect(Attributes::make()->getAttributes())
        ->toEqual([]);

    expect($this->instance->getAttributes())
        ->toEqual($this->attributes);
});

it('sets attributes', function (): void {
    expect($this->instance->setAttributes([])->getAttributes())
        ->toEqual([]);

    expect(Attributes::make()->setAttributes($this->attributes)->getAttributes())
        ->toEqual($this->attributes);
});

it('gets attribute', function (): void {
    expect($this->instance->get('bar'))
        ->toEqual('foo bar baz');

    expect($this->instance->get(0))
        ->toEqual('baz');
});

it('sets attribute', function (): void {
    expect($this->instance->set('bar', 'quux')->get('bar'))
        ->toEqual('quux');

    expect($this->instance->set(0, 'bar')->get(0))
        ->toEqual('bar');
});

it('is aware of forgotten keys', function (): void {
    expect($this->instance->forget('foo')->toHtml())
        ->toEqual('bar="foo bar baz" baz data-foo');

    expect($this->instance->forget(0)->toHtml())
        ->toEqual('bar="foo bar baz" data-foo');

    expect($this->instance->forget(['bar', 'data-foo'])->getAttributes())
        ->toEqual(['quux' => false]);
});

it('is aware of buffer: except', function (): void {
    expect($this->instance->except('foo')->toHtml())
        ->toEqual('bar="foo bar baz" baz data-foo');

    expect($this->instance->except(['foo', 0])->toHtml())
        ->toEqual('bar="foo bar baz" data-foo');

    expect($this->instance->except(['foo', 'data-foo'])->toHtml())
        ->toEqual('bar="foo bar baz" baz');
});

it('is aware of buffer: only', function (): void {
    expect($this->instance->only('foo')->toHtml())
        ->toEqual('foo="bar"');

    expect($this->instance->only(['foo', 0, 'data-foo'])->toHtml())
        ->toEqual('foo="bar" baz data-foo');
});

it('is aware of previous buffer', function (): void {
    $instance = clone $this->instance;

    expect($instance->only('foo')->except('foo')->toHtml())
        ->toEqual('bar="foo bar baz" baz data-foo');

    expect($instance->only(['foo', 'data-foo'])->except(['foo', 'data-foo'])->toHtml())
        ->toEqual('bar="foo bar baz" baz');

    expect($instance->except('foo')->only('foo')->toHtml())
        ->toEqual('foo="bar"');

    expect($instance->except(['foo', 'data-foo'])->only(['foo', 'data-foo'])->toHtml())
        ->toEqual('foo="bar" data-foo');
});

it('flushes', function (): void {
    $this->instance->flush();

    expect($this->instance->getAttributes())
        ->toBeEmpty()->toEqual([]);

    expect($this->instance->toHtml())
        ->toBeEmpty()->toEqual('');
});

it('merges', function (): void {
    $merge = ['a' => 'a', 'z' => 2];

    $this->instance->merge($merge);

    expect($this->instance->getAttributes())
        ->toEqual(array_merge($this->attributes, $merge));

    expect($this->instance->toHtml())
        ->toEqual('foo="bar" bar="foo bar baz" baz data-foo a="a" z="2"');
});

it('pipes', function (): void {
    $this->instance->pipe(function (Attributes $attributes) {
        return $attributes
            ->only(['foo', 0])
            ->add('a', 'a')
            ->add('z', 2);
    });

    expect($this->instance->getAttributes())
        ->toEqual(array_merge(
            ['a' => 'a'],
            $this->attributes,
            ['z' => 2],
        ));

    expect($this->instance->toHtml())
        ->toEqual('foo="bar" baz');

    $exceptionMessage = '';

    try {
        $this->instance->pipe(fn () => []);
    } catch (TypeError $exception) {
        $exceptionMessage = $exception->getMessage();
    }

    expect($exceptionMessage)
        ->toEqual(
            'Return value of "pipe" must be type of "Authanram\Html\Attributes", got: array',
        );
});

it('renders', function (): void {
    expect(Attributes::make()->toHtml())
        ->toBeString()->toBeEmpty()->toEqual('');

    expect($this->instance->toHtml())
        ->toEqual('foo="bar" bar="foo bar baz" baz data-foo');
});
