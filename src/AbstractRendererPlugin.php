<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRendererPlugin
{
    abstract public static function render(string $html): string;
}
