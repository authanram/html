<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Contracts\Renderable;

abstract class RendererPlugin implements Contracts\RendererPlugin
{
    protected Renderable $element;

    public function setElement(Renderable $element): static
    {
        $this->element = $element;

        return $this;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function handle(): Renderable
    {
        return $this->element;
    }

    public function render(string $html): string
    {
        return $html;
    }
}
