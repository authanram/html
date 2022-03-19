<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class Pipe
{
    abstract public function handle(mixed $passable, callable $next): callable;
}
