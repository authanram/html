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

    public function render(string $html): string
    {
        return $html;
    }
}
