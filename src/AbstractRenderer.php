<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

abstract class AbstractRenderer
{
    protected array $plugins = [];

    abstract public function render(string $tag, array $attributes = [], array $contents = []): string;

    public function setPlugins(array $plugins, array $ignore = []): static
    {
        $this->plugins = [];

        foreach ($plugins as $plugin) {
            if (is_subclass_of($plugin, AbstractPlugin::class) === false) {
                throw new InvalidArgumentException('Plugin must extend: ' . AbstractPlugin::class);
            }

            $plugin = is_string($plugin) ? new $plugin : $plugin;

            if (in_array($plugin::class, $ignore, true)) {
                continue;
            }

            $this->plugins[] = $plugin;
        }

        return $this;
    }

    protected function renderContents(array $contents): array
    {
        $rendered = [];

        foreach ($contents as $item) {
            if (is_array($item)) {
                $rendered[] = $this->render(...$item);
                continue;
            }

            if (static::isElement($item)) {
                $rendered[] = $this->render($item, [], []);
                continue;
            }

            if (is_string($item)) {
                $rendered[] = $item;
                continue;
            }

            throw new InvalidArgumentException(
                'Expected array|string as content, got: '.gettype($item),
            );
        }

        return $rendered;
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
}
