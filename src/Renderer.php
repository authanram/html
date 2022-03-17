<?php

declare(strict_types=1);

namespace Authanram\Html;

use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class Renderer extends AbstractRenderer
{
    public function render(string $tag, array $attributes = [], array $contents = []): string
    {
        $arguments = ['tag' => $tag, 'attributes' => $attributes, 'contents' => $contents];

        $plugins = $this->plugins;

        if (static::isElement($tag)) {
            $element = new $tag;

            $this->setPlugins($plugins, $element::$pluginsIgnore);

            $arguments = static::arguments($arguments, $element->toArray());
        }

        $arguments['contents'] = $this->renderContents($arguments['contents']);

        $html = trim(SpatieHtmlElement::render(...$arguments));

        /** @var AbstractPlugin $plugin */
        foreach ($this->plugins as $plugin) {
            $html = $plugin->render(trim($html));
        }

        $this->setPlugins($plugins);

        return $html;
    }
}
