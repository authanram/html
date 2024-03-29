<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Collections\AttributeCollection;

beforeEach(function () {
    $this->attributes = [
        'quux' => false,
        'foo' => 'bar',
        'bar' => 'foo bar baz',
        'baz' => 'qux',
        'data-foo' => true,
    ];

    $this->instance = AttributeCollection::make($this->attributes);
});

it('throws if attributes is not an array map', function (): void {
    new AttributeCollection(['foo', 'bar']);
})->expectExceptionMessage('Argument "$items" must be an array map.');

it('can be instantiated', function (): void {
    expect((new AttributeCollection())->toArray())
        ->toEqual([]);

    expect((new AttributeCollection($this->attributes))->toArray())
        ->toEqual($this->attributes);
});

it('can be instantiated statically', function (): void {
    expect(AttributeCollection::make()->toArray())
        ->toEqual([]);

    expect($this->instance->toArray())
        ->toEqual($this->attributes);
});

it('gets attribute', function (): void {
    expect($this->instance->get('bar'))
        ->toEqual('foo bar baz');
});

it('sets attribute', function (): void {
    expect($this->instance->set('bar', 'quux')->get('bar'))
        ->toEqual('quux');
});

it('flushes', function (): void {
    $this->instance->flush();

    expect($this->instance->toArray())
        ->toBeEmpty()->toEqual([]);

    expect($this->instance->toHtml())
        ->toBeEmpty()->toEqual('');
});

it('forwards call forget', function (): void {
    expect((clone $this->instance)->forget(['foo', 'baz', 'data-foo'])->toHtml())
        ->toEqual('quux="0" bar="foo bar baz"');
});

it('forwards call except', function (): void {
    expect((clone $this->instance)->except(['foo', 'baz', 'data-foo'])->toHtml())
        ->toEqual('quux="0" bar="foo bar baz"');
});

it('forwards call only', function (): void {
    expect((clone $this->instance)->only('foo')->toHtml())
        ->toEqual('foo="bar"');

    expect((clone $this->instance)->only(['foo', 'baz', 'data-foo'])->toHtml())
        ->toEqual('foo="bar" baz="qux" data-foo');
});

it('merges', function (): void {
    expect($this->instance->merge(['a' => 'a', 'z' => 2])->toHtml())
        ->toEqual('quux="0" foo="bar" bar="foo bar baz" baz="qux" data-foo a="a" z="2"');
});

it('pipes', function (): void {
    $this->instance->pipe(function (AttributeCollection $attributes) {
        return $attributes
            ->only(['foo'])
            ->add('a', 'a')
            ->add('z', 2);
    });

    expect($this->instance->toArray())
        ->toEqual([
            'foo' => 'bar',
            'a' => 'a',
            'z' => 2,
        ]);

    expect($this->instance->toHtml())
        ->toEqual('foo="bar" a="a" z="2"');

    $exceptionMessage = '';

    try {
        $this->instance->pipe(fn () => []);
    } catch (TypeError $exception) {
        $exceptionMessage = $exception->getMessage();
    }

    expect($exceptionMessage)
        ->toEqual(sprintf(
            '%s: Return value must be of type %s, array returned',
            AttributeCollection::class.'::pipe()',
            AttributeCollection::class,
        ));
});

it('renders', function (): void {
    expect(AttributeCollection::make()->toHtml())
        ->toBeString()->toBeEmpty()->toEqual('');

    expect($this->instance->toHtml())
        ->toEqual('quux="0" foo="bar" bar="foo bar baz" baz="qux" data-foo');
});
