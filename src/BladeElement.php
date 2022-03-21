<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Plugins\BladeRenderPlugin;

class BladeElement extends Element
{
    protected array $bladeAttributes = [];

    public function getRenderer(): AbstractRenderer
    {
        return parent::getRenderer()->addPlugin(BladeRenderPlugin::class);
    }

    public function setAttributes(array $attributes): static
    {
        foreach ($attributes as $attribute => $value) {
            if (is_string($value)) {
                $this->attributes[$attribute] = $value;

                continue;
            }

            $dataAttribute = '_'.md5($attribute);

            $this->bladeAttributes[$dataAttribute] = $value;

            $this->attributes[":$attribute"] = '$'.$dataAttribute;
        }

        return $this;
    }

    public function getBladeAttributes(): array
    {
        return $this->bladeAttributes;
    }
}
