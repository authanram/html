<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

interface Renderer
{
    /** @param RendererPlugin[] $plugins */
    public function withPlugins(array $plugins): static;

    public function render(Renderable $element): string;
}
