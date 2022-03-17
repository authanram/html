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
        $this->plugins = [];

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

    protected static function isElement(string $tag): bool
    {
        return class_exists($tag) && is_subclass_of($tag, Element::class);
    }

    protected static function arguments(array $arguments, array $argumentsElement): array
    {
        foreach ($arguments as $key => $value) {
            if ($key === 'tag' || empty($value)) {
                continue;
            }

            $argumentsElement[$key] = $value;
        }

        return $argumentsElement;
    }

    protected function renderContents(array $contents): array
    {
        $rendered = [];

        foreach ($contents as $content) {
            if (is_array($content)) {
                $rendered[] = $this->render(...$content);
                continue;
            }

            if (static::isElement($content)) {
                $rendered[] = $this->render($content, [], []);
                continue;
            }

            if (is_string($content)) {
                $rendered[] = $content;
                continue;
            }

            throw new InvalidArgumentException(
                'Expected array|string as content, got: '.gettype($content),
            );
        }

        return $rendered;
    }
}
