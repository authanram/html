<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Contracts\RendererPlugin as Contract;
use Authanram\Html\RendererPlugin;

class TestRendererPluginTwo extends RendererPlugin implements Contract
{
    public function render(string $html): string
    {
        return '<div class="plugin-two">'.$html.'</div>';
    }
}
