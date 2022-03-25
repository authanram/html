<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

interface Renderer
{
    /** @param RendererPlugin[] */
    public function setPlugins(array $plugins): static;

    public function render(Renderable $element): string;
}
