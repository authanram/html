<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Plugins\BladeRendererPlugin;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles\TestElement;
use Authanram\Html\Tests\TestFiles\TestElementWithPlugins;
use Authanram\Html\Tests\TestFiles\TestPlugin;

it('renders', function (): void {
    $result = (new Renderer())->render('p', ['class' => 'red'], ['text']);

    expect($result)->toEqual('<p class="red">text</p>');
});

it('renders element', function (): void {
    $result = (new Renderer())->render(TestElement::class);

    expect($result)->toEqual('<span class="purple">foo: <span data-x="bar">qux</span></span>');
});

it('renders element with plugins', function (): void {
    $result = (new Renderer())
        ->setPlugins([BladeRendererPlugin::class])
        ->render(TestElementWithPlugins::class, ['class' => 'blue'], ['qux']);

    expect($result)->toEqual('<div data-testplugin><div class="blue">qux</div></div>');
});

it('renders element with attributes', function (): void {
    $result = (new Renderer())->render(TestElement::class, ['class' => 'green']);

    expect($result)->toEqual('<span class="green">foo: <span data-x="bar">qux</span></span>');
});

it('renders element with contents', function (): void {
    $result = (new Renderer())->render(TestElement::class, [], ['quux']);

    expect($result)->toEqual('<span class="purple">quux</span>');
});

it('renders contents', function (): void {
    $result = (new Renderer())->render('p', ['class' => 'red'], [
        ['span', ['class' => 'green'], ['text']],
    ]);

    expect($result)->toEqual('<p class="red"><span class="green">text</span></p>');
});

it('renders with plugins', function (): void {
    $renderer = (new Renderer())->setPlugins([
        BladeRendererPlugin::class,
        TestPlugin::class,
    ]);

    $result = $renderer->render('x-html::test', ['text' => 'value'], ['foobar']);

    expect($result)->toEqual("<div data-testplugin><span>value: foobar</span></div>");
});
