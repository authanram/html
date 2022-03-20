<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRenderer
{
    /** @return AbstractRendererPlugin[] */
    abstract public function getPlugins(): array;

    /** @param AbstractRendererPlugin[] $plugins */
    abstract public function setPlugins(array $plugins): static;

    abstract public function addPlugin(AbstractRendererPlugin|string $plugin, ?string $alias = null): static;

    abstract public function pluginsHandle(string $value): string;

    abstract public function render(AbstractElement $element): string;
}
