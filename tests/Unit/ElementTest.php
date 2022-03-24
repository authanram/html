<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Tests\TestFiles;

it('renders', function (): void {
    expect(Element::make()->render())->toEqual('<div></div>');

    expect(
        Element::make()
            ->setTag('span')
            ->setAttributes(['class' => 'red'])
            ->setContents(['text'])
            ->render(),
    )->toEqual(
        '<span class="red">text</span>',
    );

    expect(
        Element::make('div', ['class' => 'green'], 'text')->render()
    )->toEqual(
        '<div class="green">text</div>',
    );
});

it('renders array contents', function (): void {
    $expectation = '<div>text&nbsp;array !</div>';

    $contents = ['text', '&nbsp;', 'array', ' ', '!'];

    expect(Element::make(null, null, $contents))->render()
        ->toEqual($expectation);

    expect(Element::make()->setContents($contents)->render())
        ->toEqual($expectation);
});

it('renders with plugins', function (): void {
    $element = Element::make('div', ['class' => 'green'], []);

    $result = $element->render([
        new TestFiles\TestRendererPluginOne('plugin-one'),
        new TestFiles\TestRendererPluginTwo(),
        new TestFiles\TestRendererPluginThree(),
    ]);

    expect($result)->toEqual(
        '<div class="plugin-three"><div class="plugin-two"><div class="plugin-one"><div class="green"></div></div></div></div>'
    );
});

it('renders contents from element', function (): void {
    $element = Element::make('div', ['class' => 'green'], [
        Element::make('span', ['class' => 'yellow'], ['foo']),
    ]);

    expect($element->render())->toEqual(
        '<div class="green"><span class="yellow">foo</span></div>',
    );
});

it('renders contents from array', function (): void {
    $element = Element::make('div', ['class' => 'green'], [
        ['tag' => 'span', 'attributes' => ['class' => 'blue'], 'contents' => ['bar']],
    ]);

    expect($element->render())->toEqual(
        '<div class="green"><span class="blue">bar</span></div>',
    );
});

it('renders contents from array with custom tag', function (): void {
    $child = ['tag' => TestFiles\TestElement::class, 'attributes' => ['class' => 'orange']];

    $element = Element::make('div', ['class' => 'green'], [$child]);

    expect($element->render())->toEqual(
        '<div class="green"><span class="orange">foo: <span data-x="bar">qux</span></span></div>',
    );
});

it('renders contents from string', function (): void {
    $element = Element::make('div', ['class' => 'green'], ['baz']);

    expect($element->render())->toEqual(
        '<div class="green">baz</div>',
    );
});
