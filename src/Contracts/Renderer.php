<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

use Authanram\Html\Collections\PluginCollection;

interface Renderer
{
    public function plugins(): PluginCollection;

    public function render(Renderable $element): string;
}
