<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

interface Renderer
{
    /** @param RendererPlugin[] $plugins */
    public function setPlugins(array $plugins): static;

    public function addPlugin(RendererPlugin $plugin): static;

    /** @param RendererPlugin[] $plugins */
    public function addPlugins(array $plugins): static;

    public function render(Renderable $element): string;
}
