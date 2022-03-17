<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Plugins\BladeRendererPlugin;
use Authanram\Html\Renderer;

it('renders to html', function (): void {
    $result = (new Renderer())->render('p', ['class' => 'red'], ['text']);

    expect($result)->toEqual('<p class="red">text</p>');
});

it('renders contents to html', function (): void {
    $result = (new Renderer())->render('p', ['class' => 'red'], [
        ['span', ['class' => 'green'], ['text']],
    ]);

    expect($result)->toEqual('<p class="red"><span class="green">text</span></p>');
});

it('renders with plugin', function (): void {
    $renderer = new Renderer();

    $renderer->setPlugins([BladeRendererPlugin::class]);

    $result = $renderer->render('x-html::test', ['text' => 'value'], ['foobar']);

    expect(trim($result))->toEqual('<span>value: foobar</span>');
});
