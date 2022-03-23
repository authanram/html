<?php

declare(strict_types=1);

namespace Authanram\Html;

/**
 * @method static add(string $key, array|string|int|bool $value = null)
 */
final class Attributes extends Collection
{
    public function toHtml(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        $strings = [];

        foreach ($this->attributes as $key => $value) {
            if (in_array($value, [null, true, ''], true)) {
                $strings[] = $key;
                continue;
            }

            if (is_int($key) && is_scalar($value)) {
                $strings[] = $value;
                continue;
            }

            $value = (string)($value === false ? 0 : $value);

            $value = htmlspecialchars($value, ENT_COMPAT);

            $strings[] = "$key=\"$value\"";
        }

        return implode(' ', $strings);
    }
}
