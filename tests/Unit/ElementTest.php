<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;

it('renders to html', function (): void {
    $result = (new Element('p', ['class' => 'red'], ['text']))->render();

    expect($result)->toEqual('<p class="red">text</p>');
});
