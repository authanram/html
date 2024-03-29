<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Contracts\RendererPlugin as Contract;
use Authanram\Html\RendererPlugin;

class TestRendererPluginOne extends RendererPlugin implements Contract
{
    public function __construct(protected string $classAttribute = '')
    {
    }

    public function render(string $html): string
    {
        return '<div class="'.$this->classAttribute.'">'.$html.'</div>';
    }
}
