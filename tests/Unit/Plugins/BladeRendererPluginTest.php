<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Plugins\BladeRendererPlugin;

beforeEach(function () {
    $this->element = Element::make(
        'x-html::test',
        [
            'text' => 'foobar',
            ':data' => ['foo' => 'bar'],
        ],
        ['quux']
    );
});

it('will authorize', function (): void {
    $plugin = (new BladeRendererPlugin())->setElement($this->element);

    expect($plugin->authorize())->toBeTrue();

    $plugin->setElement(new Element());

    expect($plugin->authorize())->toBeFalse();
});

it('renders', function (): void {
    $this->element->getRenderer()->plugins()->set([
        new BladeRendererPlugin(),
    ]);

    $result = $this->element->render();

    expect($result)->toEqual(
        '<span>foobar: quux -- bar</span>',
    );
});
