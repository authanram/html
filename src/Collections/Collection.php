<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Arr;

class Collection
{
    /** @var <string|int, mixed>[] */
    protected array $items = [];

    public static function make(array $items = []): static
    {
        return new static($items);
    }

    public function __construct(array $items = [])
    {
        $this->items = $items;
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

    public function toArray(): array
    {
        return $this->items;
    }
}
