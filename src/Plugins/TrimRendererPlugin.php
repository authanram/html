<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\RenderPlugin;

class TrimRendererPlugin extends RenderPlugin
{
    public function render(string $html): string
    {
        return trim($html);
    }
}
