<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Arr;
use Authanram\Html\AttributesRenderer;
use InvalidArgumentException;
use TypeError;

class AttributesCollection
{
    /** @var <string, bool|float|int|string>[] */
    protected array $items = [];

    public static function make(array $items = []): static
    {
        return new static($items);
    }

    public function __construct(array $items = [])
    {
        if (count($items) && Arr::isList($items)) {
            throw new InvalidArgumentException('Argument "$items" must be an array map.');
        }

        $this->items = $items;
    }

    public function add(string $key, bool|float|int|string $value): self
    {
        if (array_key_exists($key, $this->items) === false) {
            $this->items[$key] = $value;
        }

        return $this;
    }

    public function except(array|string $keys): self
    {
        $this->items = Arr::except($this->items, $keys);

        return $this;
    }

    public function flush(): self
    {
        $this->items = [];

        return $this;
    }

    public function forget(array|string $keys): self
    {
        Arr::forget($this->items, $keys);

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    public function merge(array $items): self
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function only(array|string $keys): self
    {
        $this->items = Arr::only($this->items, $keys);

        return $this;
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

    public function toArray(): array
    {
        return $this->items;
    }

    public function toHtml(): string
    {
        return AttributesRenderer::render($this->items);
    }
}
