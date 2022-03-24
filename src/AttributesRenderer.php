<?php

declare(strict_types=1);

namespace Authanram\Html;

use Closure;

class AttributesRenderer
{
    /**
     * @param <string, mixed>[] $attributes
     * @param Closure[] $handlers
     * @return string
     */
    public static function render(array $attributes, array $handlers = []): string
    {
        $handlers = array_merge(static::handlers(), $handlers);

        $strings = [];

        foreach ($attributes as $key => $value) {
            $value = is_string($value) ? trim($value) : $value;

            foreach ($handlers as $handler) {
                $value = $handler($value, $key);
            }

            if (is_int($key)) {
                $strings[] = $value;
                continue;
            }

            if (is_null($value)) {
                $strings[] = $key;
                continue;
            }

            $value = htmlspecialchars($value, ENT_COMPAT);

            $strings[] = "$key=\"$value\"";
        }

        return implode(' ', $strings);
    }

    protected static function handlers(): array
    {
        return [
            'boolean:false' => fn ($value) => $value === false ? '0' : $value,
            'boolean:true' => fn ($value) => $value === true ? null : $value,
            'empty' => fn ($value) => $value === '' ? null : $value,
            'scalar' => fn ($value) => is_scalar($value) ? (string)$value : $value,
        ];
    }
}
