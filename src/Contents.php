<?php

declare(strict_types=1);

namespace Authanram\Html;

/**
 * @method self add(string $key, string|float|int|bool $value = null)
 * @method self set(string $key, string|float|int|bool $value)
 */
final class Contents extends Collection
{
    public function toHtml(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return '';
    }
}
