<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Tests\TestFiles;

beforeEach(function () {
    $this->plugin = new TestFiles\TestRenderPluginWithoutHandlers();
});

it('will authorize', function (): void {
    expect($this->plugin->authorize())->toBeTrue();
});

it('resolves via handle', function (): void {
    $this->plugin->setElement(Element::make());

    expect($this->plugin->handle())->toBeInstanceOf(Element::class);
});

it('resolves via render', function (): void {
    expect($this->plugin->render('html'))->toEqual('html');
});

it('renders', function (): void {
    $plugin = (new TestFiles\TestRenderPlugin())->setElement(Element::make());

    $html = $plugin->handle()->setContents(['foo'])->render();

    $result = $plugin->render($html);

    expect($result)->toEqual(
        '<div data-render><p data-handle>foo</p></div>',
    );
});
