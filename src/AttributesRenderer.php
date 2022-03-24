<?php

declare(strict_types=1);

namespace Authanram\Html;

class AttributesRenderer
{
    public static function render(array $attributes): string
    {
        $strings = [];

        foreach ($attributes as $key => $value) {
            if (in_array($value, [null, true, ''], true)) {
                $strings[] = $key;
                continue;
            }

            $value = (string)($value === false ? 0 : $value);

            $value = htmlspecialchars($value, ENT_COMPAT);

            $strings[] = "$key=\"$value\"";
        }

        return implode(' ', $strings);
    }
}
