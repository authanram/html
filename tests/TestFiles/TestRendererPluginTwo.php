<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\AbstractRendererPlugin;

class TestRendererPluginTwo extends AbstractRendererPlugin
{
    public function render(string $html): string
    {
        return '<div class="plugin-two">'.$html.'</div>';
    }
}
