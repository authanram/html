<?php

declare(strict_types=1);

namespace Authanram\Html\Concerns;

use Authanram\Html\AbstractRenderer;
use Authanram\Html\Renderer;

trait HasRenderer
{
    protected AbstractRenderer $renderer;

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
