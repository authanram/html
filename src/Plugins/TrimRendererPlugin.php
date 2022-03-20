<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\AbstractRendererPlugin;

class TrimRendererPlugin extends AbstractRendererPlugin
{
    public function render(string $html): string
    {
        return trim($html);
    }
}
