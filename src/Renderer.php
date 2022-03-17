<?php

declare(strict_types=1);

namespace Authanram\Html;

use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class Renderer extends AbstractRenderer
{
    public function render(string $tag, array $attributes = [], array $contents = []): string
    {
        $html = SpatieHtmlElement::render($tag, $attributes, $this->renderContents($contents));

        /** @var AbstractPlugin $plugin */
        foreach ($this->plugins as $plugin) {
            $html = $plugin->render($html);
        }

        return $html;
    }
}
