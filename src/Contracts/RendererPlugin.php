<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

interface RendererPlugin
{
    public function setElement(Renderable $element): static;

    public function authorize(): bool;

    public function handle(): Renderable;

    public function render(string $html): string;
}
