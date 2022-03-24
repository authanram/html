<?php

declare(strict_types=1);

namespace Authanram\Html\Contracts;

use Closure;

interface RendererPlugin
{
    public function setCallbackHandle(Closure $callback): static;

    public function setCallbackRender(Closure $callback): static;

    public function setElement(Renderable $element): static;

    public function authorize(): bool;

    public function handle(): Renderable;

    public function render(string $html): string;
}
