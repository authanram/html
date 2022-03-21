<?php

declare(strict_types=1);

namespace Authanram\Html\Concerns;

use Authanram\Html\AbstractRenderer;
use Authanram\Html\AbstractRendererPlugin;
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

    /** @param AbstractRendererPlugin[] $plugins */
    public function render(array $plugins = []): string
    {
        $this->setTag($this->tag());

        $this->setAttributes($this->attributes());

        $this->setContents($this->contents());

        $renderer = $this->getRenderer();

        foreach ($plugins as $plugin) {
            $renderer->addPlugin($plugin);
        }

        return $renderer->render($this);
    }
}
