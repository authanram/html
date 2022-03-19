<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles\Pipes;

use Authanram\Html\Pipe;

class TestPipeOne extends Pipe
{
    public function handle(mixed $passable, callable $next): callable
    {
        return $next(strtoupper($passable));
    }
}
