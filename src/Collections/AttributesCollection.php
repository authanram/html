<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Arr;
use Authanram\Html\AttributesRenderer;
use InvalidArgumentException;
use TypeError;

class AttributesCollection extends Collection
{
    public function __construct(array $items = [])
    {
        if (count($items) && Arr::isList($items)) {
            throw new InvalidArgumentException('Argument "$items" must be an array map.');
        }

        parent::__construct($items);
    }

    public function add(string $key, bool|float|int|string $value): self
    {
        if (array_key_exists($key, $this->items) === false) {
            $this->items[$key] = $value;
        }

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    public function set(string $key, bool|float|int|string $value): self
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function pipe(callable $callback): static
    {
        $result = $callback($this);

        if (is_object($result) && $result::class === __CLASS__) {
            return $result;
        }

        throw new TypeError(sprintf(
            '%s: Return value must be of type %s, %s returned',
            static::class.'::'.__FUNCTION__.'()',
            static::class,
            is_object($result) ? $result::class : gettype($result),
        ));
    }

    public function toHtml(): string
    {
        return AttributesRenderer::render($this->items);
    }
}
