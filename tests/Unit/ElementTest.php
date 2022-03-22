<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Tests\TestFiles;

it('renders', function (): void {
    expect((new Element())->render())->toEqual('<div></div>');

    expect(
        (new Element())
            ->setTag('span')
            ->setAttributes(['class' => 'red'])
            ->setContents(['text'])
            ->render(),
    )->toEqual(
        '<span class="red">text</span>',
    );

    expect(
        (new Element('div', ['class' => 'green'], 'text'))->render()
    )->toEqual(
        '<div class="green">text</div>',
    );
});

it('renders array contents', function (): void {
    $expectation = '<div>text&nbsp;array !</div>';

    $contents = ['text', '&nbsp;', 'array', ' ', '!'];

    $result = (new Element(null, null, $contents))->render();

    expect($result)->toEqual($expectation);

    $result = (new Element)->setContents($contents)->render();

    expect($result)->toEqual($expectation);
});

it('renders with plugins', function (): void {
    $element = new Element('div', ['class' => 'green'], []);

    $result = $element->render([
        new TestFiles\TestRendererPluginOne('plugin-one'),
        new TestFiles\TestRendererPluginTwo(),
        new TestFiles\TestRendererPluginThree(),
    ]);

    expect($result)->toEqual(
        '<div class="plugin-three"><div class="plugin-two"><div class="plugin-one"><div class="green"></div></div></div></div>',
    );
});

it('renders contents from element', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        new Element('span', ['class' => 'yellow'], ['foo']),
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<div class="green"><span class="yellow">foo</span></div>',
    );
});

it('renders contents from array', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        ['tag' => 'span', 'attributes' => ['class' => 'blue'], 'contents' => ['bar']],
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<div class="green"><span class="blue">bar</span></div>',
    );
});

it('renders contents from array with custom tag', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        ['tag' => TestFiles\TestElement::class, 'attributes' => ['class' => 'orange']],
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<div class="green"><span class="orange">foo: <span data-x="bar">qux</span></span></div>',
    );
});

it('renders contents from string', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        'baz',
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<div class="green">baz</div>',
    );
});
