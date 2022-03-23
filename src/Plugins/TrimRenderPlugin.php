<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\RenderPlugin;

class TrimRenderPlugin extends RenderPlugin
{
    public function render(string $html): string
    {
        return trim($html);
    }
}
