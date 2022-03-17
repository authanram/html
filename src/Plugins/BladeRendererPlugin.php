<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\AbstractPlugin;
use Illuminate\Support\Facades\Blade;

class BladeRendererPlugin extends AbstractPlugin
{
    public function __construct(protected array $data = [], protected bool $cache = true)
    {
    }

    public function render(string $value): string
    {
        return Blade::render($value, $this->data, $this->cache === false);
    }
}
