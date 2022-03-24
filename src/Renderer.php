<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Contracts\Renderable;
use Authanram\Html\Plugins\ElementRendererPlugin;
use Authanram\Html\Plugins\TrimRendererPlugin;

class Renderer implements Contracts\Renderer
{
    protected PluginManager $pluginManager;

    public function __construct(array $methods = ['handle', 'render'])
    {
        $this->pluginManager = new PluginManager($methods);
    }

    public function withPlugins(array $plugins): static
    {
        if (count($plugins) === 0) {
            return $this;
        }

        $this->pluginManager->plugins()->flush()->merge([
            new ElementRendererPlugin(),
            ...$plugins,
            new TrimRendererPlugin(),
        ]);

        return $this;
    }

    public function render(Renderable $element): string
    {
        return $this->pluginManager->handle($element) ?? '';
    }
}
