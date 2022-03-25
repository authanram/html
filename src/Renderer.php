<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Collections\PluginCollection;
use Authanram\Html\Contracts;
use Authanram\Html\Contracts\RendererPlugin;
use Authanram\Html\Plugins\ElementRendererPlugin;
use Authanram\Html\Plugins\TrimRendererPlugin;

class Renderer implements Contracts\Renderer
{
    protected PluginCollection $plugins;

    /**  @param <int, RendererPlugin|string>[] $plugins */
    public function __construct(array $plugins = [])
    {
        $this->plugins = (new PluginCollection())->add($plugins);
    }

    public function plugins(): PluginCollection
    {
        return $this->plugins;
    }

    public function render(Contracts\Renderable $element): string
    {
        $this->plugins
            ->prepend(new ElementRendererPlugin())
            ->add(new TrimRendererPlugin());

        foreach (['handle', 'render'] as $method) {
            $result = $this->handleVia($element, $method);
        }

        return $result;
    }

    protected function handleVia(Contracts\Renderable $element, string $via): mixed
    {
        $plugins = $this->plugins->toArray();

        $result = null;

        foreach ($plugins as $plugin) {
            $result = (is_string($plugin) ? new $plugin() : $plugin)
                ->setElement($element)
                ->{$via}($result);
        }

        return $result;
    }
}
