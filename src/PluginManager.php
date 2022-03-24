<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Contracts\Renderable;

final class PluginManager
{
    protected array $methods = [];

    protected PluginCollection $plugins;

    public function __construct(array|string $methods)
    {
        $this->methods = is_string($methods) ? [$methods] : $methods;

        $this->plugins = new PluginCollection();
    }

    public function plugins(): PluginCollection
    {
        return $this->plugins;
    }

    public function handle(Renderable $element): mixed
    {
        $result = null;

        foreach ($this->methods as $method) {
            $result = $this->handleVia($element, $method);
        }

        return $result;
    }

    protected function handleVia(Renderable $element, string $via): mixed
    {
        $result = null;

        foreach ($this->plugins->toArray() as $plugin) {
            if (is_string($plugin)) {
                $plugin = new $plugin();
            }

            $result = $plugin->setElement($element)->{$via}($result);
        }

        return $result;
    }
}
