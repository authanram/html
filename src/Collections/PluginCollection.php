<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Authanram\Html\Contracts\RendererPlugin;

final class PluginCollection extends Collection
{
    public function set(RendererPlugin|array $plugins): self
    {
        return $this->flush()->add($plugins);
    }

    public function add(RendererPlugin|array $plugins): self
    {
        if (is_object($plugins)) {
            $this->items[] = $plugins;

            return $this;
        }

        foreach ($plugins as $plugin) {
            $this->add($plugin);
        }

        return $this;
    }

    public function prepend(RendererPlugin|array $plugins): self
    {
        $items = $this->items;

        return $this->flush()->add($plugins)->merge($items);
    }
}
