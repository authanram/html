<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;

it('renders', function (): void {
    $element = new Element('div', ['class' => 'green'], [
        new Element('span', ['class' => 'yellow'], ['foo']),
        ['span', ['class' => 'blue'], ['bar']],
        'baz',
    ]);

    $result = $element->render();

    expect($result)->toEqual(
        '<div class="green"><span class="yellow">foo</span><span class="blue">bar</span>baz</div>',
    );
});
