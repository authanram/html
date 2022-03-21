<?php

declare(strict_types=1);

namespace Authanram\Html;

class RenderPlugin extends AbstractRendererPlugin
{
    protected AbstractElement $element;

    public function setElement(AbstractElement $element): static
    {
        $this->element = $element;

        return $this;
    }

    public function authorize(AbstractElement $element): bool
    {
        return true;
    }

    public function handle(AbstractElement $element): AbstractElement
    {
        return $element;
    }

    public function render(string $html): string
    {
        return $html;
    }
}
