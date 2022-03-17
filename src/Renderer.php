<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;
use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class Renderer extends AbstractRenderer
{
    public function render(AbstractElement $element): string
    {
        return trim(SpatieHtmlElement::render(
            $element->getTag(),
            $element->getAttributes(),
            $this->renderContents($element->getContents()),
        ));
    }

    protected function renderContents(array $elements): array
    {
        $rendered = [];

        foreach ($elements as $element) {
            if (is_string($element)) {
                $rendered[] = $element;
                continue;
            }

            if (is_array($element)) {
                $rendered[] = (new Element(...$element))->render();
                continue;
            }

            if (is_object($element) && is_subclass_of($element::class, AbstractElement::class)) {
                $rendered[] = $element->render();
                continue;
            }

            throw new InvalidArgumentException('Invalid element:'.print_r($element));
        }

        return $rendered;
    }
}
