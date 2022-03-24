<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles;

test('renderer can be get', function (): void {
    $element = new Element();

    expect($element->getRenderer())->toBeInstanceOf(Renderer::class);

    $element->setRenderer(new TestFiles\TestRenderer());

    expect($element->getRenderer())->toBeInstanceOf(TestFiles\TestRenderer::class);
});

test('renderer can be set', function (): void {
    $element = (new Element())->setRenderer(new TestFiles\TestRenderer());

    expect($element->getRenderer())->toBeInstanceOf(TestFiles\TestRenderer::class);
});
