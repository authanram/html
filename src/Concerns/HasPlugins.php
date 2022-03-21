<?php

declare(strict_types=1);

namespace Authanram\Html\Concerns;

use Authanram\Html\AbstractElement;
use Authanram\Html\AbstractRendererPlugin;
use InvalidArgumentException;

trait HasPlugins
{
    /** @var AbstractRendererPlugin[] */
    protected array $plugins = [];

    protected array $pluginsIgnored = [];

    public function getPlugins(): array
    {
        return array_filter($this->plugins, function ($plugin) {
            return in_array($plugin::class, $this->pluginsIgnored, true) === false;
        });
    }

    public function setPlugins(array $plugins): static
    {
        foreach ($plugins as $plugin) {
            $this->addPlugin($plugin);
        }

        return $this;
    }

    public function setPluginsIgnored(array $pluginsIgnored): static
    {
        $this->pluginsIgnored = $pluginsIgnored;

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

    public function pluginsHandle(AbstractElement $value): AbstractElement
    {
        $plugins = $this->getPlugins();

        foreach ($plugins as $plugin) {
            if ($plugin->authorize($value) === false) {
                continue;
            }

            $value = $plugin->handle($value);
        }

        return $value;
    }

    public function pluginsRender(string $value, AbstractElement $element): string
    {
        $plugins = $this->getPlugins();

        foreach ($plugins as $plugin) {
            if ($plugin->authorize($element) === false) {
                continue;
            }

            $value = $plugin->setElement($element)->render($value);
        }

        return $value;
    }
}
