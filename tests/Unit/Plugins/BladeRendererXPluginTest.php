<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\Plugins\BladeRendererPlugin;

it('renders', function (): void {
    $element = new Element(
        'x-html::test',
        [
            'text' => 'foobar',
            ':data' => ['foo' => 'bar'],
        ],
        ['quux']
    );

    $element->getRenderer()->setPlugins([
        new BladeRendererPlugin(),
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<span>foobar: quux -- bar</span>',
    );
});
