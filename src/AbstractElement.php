<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractElement
{
    abstract public function boot(): static;

    abstract public function getTag(): string;

    abstract public function getAttributes(): array;

    abstract public function getContents(): array;

    abstract public function getRenderer(): AbstractRenderer;

    abstract public function setTag(string $tag): static;

    abstract public function setAttributes(array $attributes): static;

    abstract public function setContents(array $contents): static;

    abstract public function setRenderer(AbstractRenderer $renderer): static;

    /** @param AbstractRendererPlugin[] $plugins */
    abstract public function render(array $plugins = []): string;
}
