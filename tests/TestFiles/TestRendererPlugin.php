<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\AbstractRendererPlugin;

class TestRendererPlugin extends AbstractRendererPlugin
{
    public static function render(string $html): string
    {
        return '<div class="test-render-plugin">'.$html.'</div>';
    }
}
