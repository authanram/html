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
            $element->getAttributes(),
            $this->renderContents($element->getContents()),
        );

        return $this->pluginsRender($html, $element);
    }

    protected function renderContents(array $elements): array
    {
        $rendered = [];

        $isElement = fn ($element) => is_object($element)
            && is_subclass_of($element::class, AbstractElement::class);

        foreach ($elements as $element) {
            $rendered[] = match (true) {
                is_string($element) => $element,
                is_array($element) => static::renderArrayElement($element),
                $isElement($element) => $element->render(),
                default => throw new InvalidArgumentException('Invalid element: '.print_r($element)),
            };
        }

        return $rendered;
    }

    protected static function renderArrayElement(array $element): string
    {
        if (is_subclass_of($element['tag'], AbstractElement::class)) {
            $instance = new $element['tag'];

            $element = [
                $instance->getTag(),
                count($element['attributes'] ?? [])
                    ? $element['attributes']
                    : $instance->getAttributes(),
                count($element['contents'] ?? [])
                    ? $element['contents']
                    : $instance->getContents(),
            ];
        }

        return (new Element(...$element))->render();
    }
}
