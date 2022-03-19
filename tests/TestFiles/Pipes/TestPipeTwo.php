<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles\Pipes;

use Authanram\Html\Pipe;

class TestPipeTwo extends Pipe
{
    public function handle(mixed $passable, callable $next): callable
    {
        $passable = "<strong>$passable</strong>";

        return $next($passable);
    }
}
