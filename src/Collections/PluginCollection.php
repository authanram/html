<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Authanram\Html\Contracts\RendererPlugin;

final class PluginCollection extends Collection
{
    public function add(RendererPlugin $value): self
    {
        $this->items[] = $value;

        return $this;
    }

    public function prepend(RendererPlugin $plugin): self
    {
        array_unshift($this->items, $plugin);

        return $this;
    }
}
