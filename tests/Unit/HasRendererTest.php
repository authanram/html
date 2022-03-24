<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles;

beforeEach(function () {
    $this->element = Element::make();
});

test('renderer can be get', function (): void {
    expect($this->element->getRenderer())
        ->toBeInstanceOf(Renderer::class);

    $this->element->setRenderer(new TestFiles\TestRenderer());

    expect($this->element->getRenderer())
        ->toBeInstanceOf(TestFiles\TestRenderer::class);
});

test('renderer can be set', function (): void {
    $this->element->setRenderer(new TestFiles\TestRenderer());

    expect($this->element->getRenderer())
        ->toBeInstanceOf(TestFiles\TestRenderer::class);
});
