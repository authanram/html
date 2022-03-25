<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

use Authanram\Html\Collections\AttributeCollection;

interface Renderable
{
    public function getTag(): string;

    public function getAttributes(): AttributeCollection;

    public function getContents(): array;

    public function getRenderer(): Renderer;

    public function setTag(string $tag): static;

    public function setAttributes(array $attributes): static;

    public function setContents(array $contents): static;

    public function setRenderer(Renderer $renderer): static;

    public function tag(): string;

    public function attributes(): array;

    public function contents(): array;

    public function renderer(): Renderer;

    public function render(): string;
}
