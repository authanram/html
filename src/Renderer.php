<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Contracts;
use Authanram\Html\Plugins\ElementRendererPlugin;
use Authanram\Html\Plugins\TrimRendererPlugin;

class Renderer implements Contracts\Renderer
{
    protected PluginManager $pluginManager;

    public function __construct(array $methods = ['handle', 'render'])
    {
        $this->pluginManager = new PluginManager($methods);
    }

    public function setPlugins(array $plugins): static
    {
        if (count($plugins) === 0) {
            return $this;
        }

        $this->pluginManager->getPluginCollection()->flush()->merge($plugins);

        return $this;
    }

    public function addPlugin(Contracts\RendererPlugin $plugin): static
    {
        $this->pluginManager->getPluginCollection()->add($plugin);

        return $this;
    }

    public function addPlugins(array $plugins): static
    {
        foreach ($plugins as $plugin) {
            $this->addPlugin($plugin);
        }

        return $this;
    }

    public function render(Contracts\Renderable $element): string
    {
        $this->pluginManager->getPluginCollection()
            ->prepend(new ElementRendererPlugin())
            ->add(new TrimRendererPlugin());

        return $this->pluginManager->handle($element) ?? '';
    }
}
