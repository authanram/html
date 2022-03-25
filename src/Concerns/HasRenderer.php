<?php

declare(strict_types=1);

namespace Authanram\Html\Concerns;

use Authanram\Html\Contracts;
use Authanram\Html\Renderer;

trait HasRenderer
{
    protected Contracts\Renderer $renderer;

    public function getRenderer(): Contracts\Renderer
    {
        $this->renderer ??= new Renderer();

        return $this->renderer;
    }

    public function setRenderer(Contracts\Renderer $renderer): static
    {
        $this->renderer = $renderer;

        return $this;
    }

    public function render(array $plugins = []): string
    {
        $this->setTag($this->tag())
            ->setAttributes($this->attributes())
            ->setContents($this->contents());

        if (count($plugins)) {
            $this->getRenderer()->setPlugins($plugins);
        }

        return $this->getRenderer()->render($this);
    }
}
