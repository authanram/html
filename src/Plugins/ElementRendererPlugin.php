<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\Contracts\Renderable;
use Authanram\Html\Element;
use Authanram\Html\RendererPlugin;
use InvalidArgumentException;

class ElementRendererPlugin extends RendererPlugin
{
    public function render(?string $html): string
    {
        $rendered = '';

        $isElement = static fn ($element) => is_object($element)
            && is_subclass_of($element::class, Renderable::class);

        $contents = $this->element->getContents();

        foreach ($contents as $content) {
            $rendered .= match (true) {
                is_string($content) => $content,
                is_array($content) => static::renderFromArray($content),
                $isElement($content) => $content->render(),
                default => throw new InvalidArgumentException('Invalid element: '.print_r($content)),
            };
        }

        $attributes = $this->element->getAttributes()->toHtml();

        return sprintf(
            static::tagTemplate($this->element->tag()),
            $this->element->tag(),
            $attributes !== '' ? " $attributes" : $attributes,
            $rendered,
        );
    }

    public static function renderFromArray(array $element): string
    {
        $tag = $element['tag'] ?? 'div';

        if (is_subclass_of($tag, Renderable::class)) {
            $instance = new $tag();

            $element = [
                $instance->getTag(),
                $element['attributes'] ?? $instance->getAttributes()->toArray(),
                $element['contents'] ?? $instance->getContents(),
            ];
        }

        return (new Element(...$element))->render();
    }

    protected static function tagTemplate(string $tag): string
    {
        return in_array($tag, static::selfClosingTags())
            ? '<%s %s />'
            : "<%s%s>%s</%1\$s>";
    }

    protected static function selfClosingTags(): array
    {
        return [
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'keygen',
            'link',
            'menuitem',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
        ];
    }
}
