<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;
use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class Renderer extends AbstractRenderer
{
    use Concerns\HasPlugins;

    public function render(AbstractElement $element): string
    {
        $element = $this->pluginsHandle($element);

        $html = SpatieHtmlElement::render(
            $element->getTag(),
            $element->getAttributes()->toArray(),
            $this->renderContents($element->getContents()),
        );

        return $this->pluginsRender($html, $element);
    }

    protected function renderContents(array $elements): array
    {
        $rendered = [];

        $isElement = static fn ($element) => is_object($element)
            && is_subclass_of($element::class, AbstractElement::class);

        foreach ($elements as $element) {
            $rendered[] = match (true) {
                is_string($element) => $element,
                is_array($element) => static::renderFromArray($element),
                $isElement($element) => $element->render(),
                default => throw new InvalidArgumentException('Invalid element: '.print_r($element)),
            };
        }

        return $rendered;
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
