<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\AbstractRendererPlugin;

class TestRendererPluginOne extends AbstractRendererPlugin
{
    public function __construct(protected string $classAttribute)
    {
    }

    public function render(string $html): string
    {
        return '<div class="'.$this->classAttribute.'">'.$html.'</div>';
    }
}
