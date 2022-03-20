<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;
use Spatie\HtmlElement\HtmlElement as SpatieHtmlElement;

class Renderer extends AbstractRenderer
{
    /** @var AbstractRendererPlugin[] */
    protected array $plugins = [];

    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function setPlugins(array $plugins): static
    {
        foreach ($plugins  as $plugin) {
            $this->addPlugin($plugin);
        }

        return $this;
    }

    public function addPlugin(AbstractRendererPlugin|string $plugin): static
    {
        if (is_subclass_of($plugin, AbstractRendererPlugin::class) === false) {
            $plugin = is_object($plugin) ? $plugin::class : $plugin;

            throw new InvalidArgumentException(
                'Class "'.$plugin.'" must be a subclass of: '.AbstractRendererPlugin::class,
            );
        }

        $this->plugins[] = $plugin;

        return $this;
    }

    public function render(AbstractElement $element): string
    {
        $html =  trim(SpatieHtmlElement::render(
            $element->getTag(),
            $element->getAttributes(),
            $this->renderContents($element->getContents()),
        ));

        foreach ($this->plugins as $plugin) {
            $html = $plugin::render($html);
        }

        return $html;
    }

    protected function renderContents(array $elements): array
    {
        $rendered = [];

        $isElement = fn ($element) => is_object($element)
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

    protected static function renderFromArray(array $element): string
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
