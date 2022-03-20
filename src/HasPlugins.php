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

    public function addPlugin(AbstractRendererPlugin|string $plugin, ?string $alias = null): static
    {
        $classname = is_object($plugin) ? $plugin::class : $plugin;

        if (is_subclass_of($classname, AbstractRendererPlugin::class) === false) {
            throw new InvalidArgumentException(
                'Class "'.$classname.'" must be a subclass of: '.AbstractRendererPlugin::class,
            );
        }

        $instance = is_string($plugin) ? new $plugin : $plugin;

        if (is_null($alias)) {
            $this->plugins[] = $instance;
        } else {
            $this->plugins[$alias] = $instance;
        }

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
