<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

trait HasPlugins
{
    /** @var AbstractRendererPlugin[] */
    protected array $plugins = [];

    protected array $pluginsIgnored = [];

    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function setPlugins(array $plugins): static
    {
        foreach ($plugins as $plugin) {
            $this->addPlugin($plugin);
        }

        return $this;
    }

    public function addPlugin(AbstractRendererPlugin|string $plugin): static
    {
        if (is_subclass_of($plugin, AbstractRendererPlugin::class) === false) {
            $plugin = is_object($plugin) ? $plugin::class : $plugin;

            throw new InvalidArgumentException(
                'Class "'.$plugin.'" must be a subclass of: '.AbstractRendererPlugin::class,
            );
        }

        $this->plugins[] = is_string($plugin) ? new $plugin : $plugin;

        return $this;
    }

    public function setPluginsIgnored(array $pluginsIgnored): static
    {
        $this->pluginsIgnored = $pluginsIgnored;

        return $this;
    }

    public function pluginsHandle(string $value): string
    {
        foreach ($this->plugins as $plugin) {
            if (in_array($plugin::class, $this->pluginsIgnored, true)) {
                continue;
            }

            $value = $plugin->render($value);
        }

        return $value;
    }
}
