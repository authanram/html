<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRendererPlugin
{
    abstract public function render(string $html): string;
}
