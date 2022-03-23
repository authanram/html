<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

/**
 * @method self add(string $key, string|float|int|bool $value = null)
 * @method self set(string $key, string|float|int|bool $value)
 */
final class Attributes extends Collection
{
    public function __construct(array $items = [])
    {
        if (count($items) && array_is_list($items)) {
            throw new InvalidArgumentException('Argument "$items" must be an array map.');
        }

        parent::__construct($items);
    }

    public function toHtml(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        $strings = [];

        foreach ($this->all() as $key => $value) {
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
