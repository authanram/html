<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Tests\TestFiles;

it('resolves tag template', function (): void {
    $element = (new TestFiles\TestElementSelfClosing())
        ->setAttributes([
            'src' => 'https://...',
            'alt' => 'image',
        ]);

    expect($element->render())->toEqual(
        '<img src="https://..." alt="image"/>',
    );
});
