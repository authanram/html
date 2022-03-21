<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\AbstractElement;
use Authanram\Html\RenderPlugin;
use Illuminate\Support\Facades\Blade;

class BladeRenderPlugin extends RenderPlugin
{
    protected array $attributes = [];

    public function authorize(AbstractElement $element): bool
    {
        return str_starts_with($element->getTag(), 'x-');
    }

    public function handle(AbstractElement $element): AbstractElement
    {
        $attributes = $element->getAttributes();

        foreach ($attributes as $key => $value) {
            if (is_int($key) || $key[0] !== ':') {
                continue;
            }

            $attributeKey = ltrim($key, ':');

            $this->attributes[$attributeKey] = $value;

            $attributes[$key] = "\$$attributeKey";
        }

        $element->setAttributes($attributes);

        return $element;
    }

    public function render(string $html): string
    {
        return trim(Blade::render($html, $this->attributes));
    }
}
