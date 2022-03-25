<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\Contracts;
use Authanram\Html\RendererPlugin;

class TrimRendererPlugin extends RendererPlugin implements Contracts\RendererPlugin
{
    public function render(string $html): string
    {
        return trim($html);
    }
}
