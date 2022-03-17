<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractElement
{
    protected AbstractRenderer $renderer;

    abstract public function getTag(): string;
    abstract public function getAttributes(): array;
    abstract public function getContents(): array;

    public function getRenderer(): AbstractRenderer
    {
        $this->renderer ??= new Renderer();

        return $this->renderer;
    }

    public function setRenderer(AbstractRenderer $renderer): static
    {
        $this->renderer = $renderer;

        return $this;
    }

    public function render(): string
    {
        return $this->getRenderer()->render($this);
    }
}
