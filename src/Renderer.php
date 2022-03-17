<?php

declare(strict_types=1);

namespace Authanram\Html;

class Renderer extends AbstractRenderer
{
    public function render(string $tag, array $attributes = [], array $contents = []): string
    {
        $arguments = ['tag' => $tag, 'attributes' => $attributes, 'contents' => $contents];

        $plugins = $this->plugins;

        if (static::isElement($tag)) {
            $element = new $tag();

            $arguments = static::mergeArguments($arguments, $element->toArray());
        }

        $html = trim(parent::render(...$arguments));

        /** @var AbstractPlugin $plugin */
        foreach ($plugins as $plugin) {
            $html = $plugin->render(trim($html));
        }

        return $html;
    }

    protected static function isElement(string $tag): bool
    {
        return class_exists($tag) && is_subclass_of($tag, Element::class);
    }

    protected static function mergeArguments(array $arguments, array $argumentsElement): array
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
