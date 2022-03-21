<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\RenderPlugin;

class TestRendererPluginTwo extends RenderPlugin
{
    public function render(string $html): string
    {
        return '<div class="plugin-two">'.$html.'</div>';
    }
}
