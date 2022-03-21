<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\BladeElement;

it('renders', function (): void {
    $element = new BladeElement(
        'x-html::test', [
            'text' => 'foobar',
            'data' => ['foo' => 'bar'],
        ],
        ['quux']
    );

    $result = $element->render();

    expect($result)->toEqual(
        '<span>foobar: quux -- bar</span>',
    );
});
