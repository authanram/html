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

it('forwards call forget', function (): void {
    expect((clone $this->instance)->forget(['foo', 0, 'data-foo'])->toHtml())
        ->toEqual('quux="0" bar="foo bar baz"');
});

it('forwards call except', function (): void {
    expect((clone $this->instance)->except(['foo', 0, 'data-foo'])->toHtml())
        ->toEqual('quux="0" bar="foo bar baz"');
});

it('forwards call only', function (): void {
    expect((clone $this->instance)->only('foo')->toHtml())
        ->toEqual('foo="bar"');

    expect((clone $this->instance)->only(['foo', 0, 'data-foo'])->toHtml())
        ->toEqual('foo="bar" baz data-foo');
});

it('flushes', function (): void {
    $this->instance->flush();

    expect($this->instance->getAttributes())
        ->toBeEmpty()->toEqual([]);

    expect($this->instance->toHtml())
        ->toBeEmpty()->toEqual('');
});

it('merges', function (): void {
    expect($this->instance->merge(['a' => 'a', 'z' => 2])->toHtml())
        ->toEqual('quux="0" foo="bar" bar="foo bar baz" baz data-foo a="a" z="2"');
});

it('pipes', function (): void {
    $this->instance->pipe(function (Attributes $attributes) {
        return $attributes
            ->only(['foo', 0])
            ->add('a', 'a')
            ->add('z', 2);
    });

    expect($this->instance->getAttributes())
        ->toEqual([
            'foo' => 'bar',
            0 => 'baz',
            'a' => 'a',
            'z' => 2,
        ]);

    expect($this->instance->toHtml())
        ->toEqual('foo="bar" baz a="a" z="2"');

    $exceptionMessage = '';

    try {
        $this->instance->pipe(fn () => []);
    } catch (TypeError $exception) {
        $exceptionMessage = $exception->getMessage();
    }

    expect($exceptionMessage)
        ->toEqual(sprintf(
            '%s: Return value must be of type %s, array returned',
            'Authanram\Html\Attributes::pipe()',
            Attributes::class,
        ));
});

it('renders', function (): void {
    expect(Attributes::make()->toHtml())
        ->toBeString()->toBeEmpty()->toEqual('');

    expect($this->instance->toHtml())
        ->toEqual('quux="0" foo="bar" bar="foo bar baz" baz data-foo');
});
