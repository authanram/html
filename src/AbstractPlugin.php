<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractPlugin
{
    abstract public function render(string $value): string;
}
