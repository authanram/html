<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;
use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

abstract class AbstractRenderer
{
    protected array $plugins = [];

    public function setPlugins(array $plugins): static
    {
        foreach ($plugins as $plugin) {
            if (is_subclass_of($plugin, AbstractPlugin::class) === false) {
                throw new InvalidArgumentException('Plugin must extend: '.AbstractPlugin::class);
            }

            $this->plugins[] = is_string($plugin) ? new $plugin : $plugin;
        }

        return $this;
    }

    public function render(string $tag, array $attributes, array $contents): string
    {
        return SpatieHtmlElement::render($tag, $attributes, $this->renderContents($contents));
    }

    protected function renderContents(array $contents): array
    {
        $rendered = [];

        foreach ($contents as $content) {
            if (is_string($content) || is_array($content)) {
                $rendered[] = is_array($content) ? $this->render(...$content) : $content;

                continue;
            }

            throw new InvalidArgumentException(
                'Expected array|string as content, got: '.gettype($content),
            );
        }

        return $rendered;
    }
}
