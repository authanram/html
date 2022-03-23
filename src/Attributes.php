<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

/**
 * @method mixed get(string $key)
 * @method self except(array|string $keys)
 * @method self forget(array|string $keys)
 * @method self only(array|string $keys)
 */
final class Attributes extends Collection
{
    protected static array $collectionMethods = [
        'except',
        'forget',
        'get',
        'only',
    ];

    public function __construct(array $items = [])
    {
        if (count($items) && array_is_list($items)) {
            throw new InvalidArgumentException('Argument "$items" must be an array map.');
        }

        parent::__construct($items);
    }

    public function set(string|int $key, string|float|int|bool $value): self
    {
        $this->items = $this->items->put($key, $value);

        return $this;
    }

    public function add(string|int $key, string|float|int|bool $value): self
    {
        if ($this->items->keys()->contains($key) === false) {
            $this->items = $this->items->merge([$key => $value]);
        }

        return $this;
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
