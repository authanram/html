<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles\TestElement;

beforeEach(function () {
    $this->renderer = new Renderer();
});

it('renders', function (): void {
    $element = new Element('div', ['class' => 'green'], []);

    $result = $this->renderer->render($element);

    expect($result)->toEqual(
        '<div class="green"></div>',
    );
});

it('renders contents from element', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        new Element('span', ['class' => 'yellow'], ['foo']),
    ]);

    $result = $this->renderer->render($element);

    expect($result)->toEqual(
        '<div class="green"><span class="yellow">foo</span></div>',
    );
});

it('renders contents from array', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        ['tag' => 'span', 'attributes' => ['class' => 'blue'], 'contents' => ['bar']],
    ]);

    $result = $this->renderer->render($element);

    expect($result)->toEqual(
        '<div class="green"><span class="blue">bar</span></div>',
    );
});

it('renders contents from array with custom tag', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        ['tag' => TestElement::class, 'attributes' => ['class' => 'orange']],
    ]);

    $result = $this->renderer->render($element);

    expect($result)->toEqual(
        '<div class="green"><span class="orange">foo: <span data-x="bar">qux</span></span></div>',
    );
});

it('renders contents from string', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        'baz',
    ]);

    $result = $this->renderer->render($element);

    expect($result)->toEqual(
        '<div class="green">baz</div>',
    );
});
