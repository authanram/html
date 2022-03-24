<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\Contracts\Renderable;
use Authanram\Html\RendererPlugin;
use Illuminate\Support\Facades\Blade;

class BladeRendererPlugin extends RendererPlugin
{
    protected array $attributes = [];

    public function authorize(): bool
    {
        return str_starts_with($this->element->getTag(), 'x-');
    }

    public function handle(): Renderable
    {
        $attributes = $this->element->getAttributes()->toArray();

        foreach ($attributes as $key => $value) {
            if (is_int($key) || $key[0] !== ':') {
                continue;
            }

            $attributeKey = ltrim($key, ':');

            $this->attributes[$attributeKey] = $value;

            $attributes[$key] = "\$$attributeKey";
        }

        $this->element->setAttributes($attributes);

        return $this->element;
    }

    public function render(string $html): string
    {
        return Blade::render($html, $this->attributes);
    }
}
