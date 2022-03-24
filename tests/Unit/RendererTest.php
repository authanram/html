<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles;

beforeEach(function () {
    $this->element = Element::make(
        'div',
        ['class' => 'green'],
        ['baz'],
    );

    $this->renderer = (new Renderer())
        ->setPlugins([
            new TestFiles\TestRendererPluginOne('plugin-one'),
            new TestFiles\TestRendererPluginTwo(),
            new TestFiles\TestRendererPluginThree(),
        ]);
});

it('renders', function (): void {
    $this->element->setRenderer(new Renderer());

    $result = $this->element->render();

    expect($result)->toEqual(
        '<div class="green">baz</div>',
    );
});

it('renders with plugins', function (): void {
    $this->element->setRenderer($this->renderer);

    $result = $this->element->render();

    expect($result)->toEqual(
        '<div class="plugin-three"><div class="plugin-two"><div class="plugin-one"><div class="green">baz</div></div></div></div>',
    );
});
