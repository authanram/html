<?php

declare(strict_types=1);

namespace Authanram\Html;

class Renderer extends AbstractRenderer
{
    public function render(string $tag, array $attributes = [], array $contents = []): string
    {
        $arguments = ['tag' => $tag, 'attributes' => $attributes, 'contents' => $contents];

        if (static::isElement($tag)) {
            $arguments = static::mergeArguments($arguments);
        }

        $html = parent::render(...$arguments);

        /** @var AbstractPlugin $plugin */
        foreach ($this->plugins as $plugin) {
            $html = $plugin->render($html);
        }

        return $html;
    }

    protected static function isElement(string $tag): bool
    {
        return class_exists($tag) && is_subclass_of($tag, Element::class);
    }

    protected static function mergeArguments(array $arguments): array
    {
        $argumentsElement = (new $arguments['tag']())->toArray();

        foreach ($arguments as $key => $value) {
            if ($key === 'tag' || empty($value)) {
                continue;
            }

            $argumentsElement[$key] = $value;
        }

        return $argumentsElement;
    }
}
