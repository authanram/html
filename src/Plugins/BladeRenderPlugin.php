<?php

declare(strict_types=1);

namespace Authanram\Html\Plugins;

use Authanram\Html\BladeElement;
use Authanram\Html\RenderPlugin;
use Illuminate\Support\Facades\Blade;

/**
 * @property BladeElement $element
 */
class BladeRenderPlugin extends RenderPlugin
{
    public function render(string $html): string
    {
        return trim(Blade::render($html, $this->element->getBladeAttributes()));
    }
}
