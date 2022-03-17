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
            /** @noinspection PhpUndefinedFieldInspection */
            $this->setPlugins($plugins, $tag::$pluginsIgnore);

            $arguments = static::mergeArguments($arguments, (new $tag)->toArray());
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
