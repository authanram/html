<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Tests\TestFiles\TestElement;

it('renders', function (): void {
    $result = (new Element('p', ['class' => 'red'], ['text']))->render();

    expect($result)->toEqual('<p class="red">text</p>');
});

it('renders custom element', function (): void {
    $result = (new TestElement())->render();

    expect($result)->toEqual('<span class="purple">foo: <span data-x="bar">qux</span></span>');
});
