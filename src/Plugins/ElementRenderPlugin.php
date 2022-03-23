<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\AbstractElement;
use Authanram\Html\Element;
use Authanram\Html\RenderPlugin;
use InvalidArgumentException;
use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class ElementRenderPlugin extends RenderPlugin
{
    public function render(?string $html): string
    {
        $rendered = [];

        $isElement = static fn ($element) => is_object($element)
            && is_subclass_of($element::class, AbstractElement::class);

        $contents = $this->element->getContents();

        foreach ($contents as $content) {
            $rendered[] = match (true) {
                is_string($content) => $content,
                is_array($content) => static::renderFromArray($content),
                $isElement($content) => $content->render(),
                default => throw new InvalidArgumentException('Invalid element: '.print_r($content)),
            };
        }

        return SpatieHtmlElement::render(
            $this->element->getTag(),
            $this->element->getAttributes()->toArray(),
            $rendered,
        );
    }

    public static function renderFromArray(array $element): string
    {
        $tag = $element['tag'] ?? 'div';

        if (is_subclass_of($tag, AbstractElement::class)) {
            $instance = new $tag();

            $element = [
                $instance->getTag(),
                $element['attributes'] ?? $instance->getAttributes()->toArray(),
                $element['contents'] ?? $instance->getContents(),
            ];
        }

        return (new Element(...$element))->render();
    }
}
