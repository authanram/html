<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Pipeline;
use Authanram\Html\Tests\TestFiles\Pipes;

it('pipes the passable', function (): void {
    $result = (new Pipeline())
        ->send('text')
        ->through([
            Pipes\TestPipeOne::class,
            Pipes\TestPipeTwo::class,
        ])->process();

    expect($result)->toEqual('<strong>TEXT</strong>');
});
