<?php

declare(strict_types=1);

namespace Authanram\Html;

class Renderer extends AbstractRenderer
{
    public function render(string $tag, array $attributes = [], array $contents = []): string
    {
        $arguments = ['tag' => $tag, 'attributes' => $attributes, 'contents' => $contents];

        if (static::isElement($tag)) {
            $plugins = $this->plugins;

            $element = new $tag();

            $arguments = static::arguments($arguments, $element->toArray());

            $this->setPlugins(array_filter($plugins, function ($plugin) use ($element) {
                return in_array($plugin::class, $element::$pluginsIgnore, true) === false;
            }));
        }

        $html = trim(parent::render(...$arguments));

        /** @var AbstractPlugin $plugin */
        foreach ($this->plugins as $plugin) {
            $html = $plugin->render(trim($html));
        }

        if (isset($plugins)) {
            $this->setPlugins($plugins);
        }

        return $html;
    }
}
