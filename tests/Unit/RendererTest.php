<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Renderer;
use Authanram\Html\Tests\TestFiles;

beforeEach(function () {
    $this->element = new Element('div', ['class' => 'green'], [
        'baz',
    ]);

    $this->renderer = (new Renderer())
        ->addPlugin(new TestFiles\TestRendererPluginOne('plugin-one'))
        ->addPlugin(new TestFiles\TestRendererPluginTwo())
        ->addPlugin(new TestFiles\TestRendererPluginThree());
});

it('renders with plugins', function (): void {
    $this->element->setRenderer($this->renderer);

    $result = $this->element->render();

    expect($result)->toEqual(
        '<div class="plugin-three"><div class="plugin-two"><div class="plugin-one"><div class="green">baz</div></div></div></div>',
    );
});

it('renders with ignored plugins', function (): void {
    $this->renderer->setPluginsIgnored([
        TestFiles\TestRendererPluginTwo::class,
    ]);

    $this->element->setRenderer($this->renderer);

    $result = $this->element->render();

    expect($result)->toEqual(
        '<div class="plugin-three"><div class="plugin-one"><div class="green">baz</div></div></div>',
    );
});
