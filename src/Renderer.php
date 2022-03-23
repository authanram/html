<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Plugins\ElementRenderPlugin;
use Authanram\Html\Plugins\TrimRenderPlugin;

class Renderer extends AbstractRenderer
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
            new ElementRenderPlugin(),
            ...$plugins,
            new TrimRenderPlugin(),
        ]);

        return $this;
    }

    public function render(AbstractElement $element): string
    {
        return $this->pluginManager->handle($element);
    }
}
