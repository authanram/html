<?php

declare(strict_types=1);

namespace Authanram\Html;

use Illuminate\Support\Arr;
use JetBrains\PhpStorm\Pure;
use TypeError;

class Attributes
{
    protected array $attributes = [];

    protected array $buffer = [];

    #[Pure] public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function get(string|int $key, mixed $default = null): mixed
    {
        return Arr::get($this->attributes, $key, $default);
    }

    public function set(string|int $key, array|string|int|bool $value = null): static
    {
        $this->attributes = Arr::set($this->attributes, $key, $value);

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function add(string|int $key, array|string|int|bool $value = null): static
    {
        $value = is_array($value) ? implode(' ', $value) : $value;

        $this->attributes = Arr::add($this->attributes, $key, $value);

        return $this;
    }

    public function merge(Attributes|array $attributes): static
    {
        $this->attributes = is_array($attributes)
            ? array_merge($this->attributes, $attributes)
            : array_merge($this->attributes, $attributes->toArray());

        return $this;
    }

    public function except(array|string|int $keys): static
    {
        $this->buffer(__FUNCTION__, $keys);

        return $this;
    }

    public function only(array|string|int $keys): static
    {
        $this->buffer(__FUNCTION__, $keys);

        return $this;
    }

    public function forget(array|string|int $keys): static
    {
        Arr::forget($this->attributes, $keys);

        return $this;
    }

    public function pipe(callable $callback): static
    {
        $result = $callback($this);

        if (is_object($result) && $result::class === __CLASS__) {
            return $result;
        }

        throw new TypeError(sprintf(
            'Return value of "%s" must be type of "%s", got: %s',
            __FUNCTION__,
            __CLASS__,
            gettype($result),
        ));
    }

    public function flush(): static
    {
        $this->attributes = [];

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributesBuffered();
    }

    public function toHtml(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        $attributes = $this->attributesBuffered(true);

        $string = '';

        foreach ($attributes as $key => $value) {
            if ($value === false) {
                continue;
            }

            if ($value === true) {
                $string .= ' '.$key;
                continue;
            }

            if (is_int($key)) {
                $string .= ' '.$value;
                continue;
            }

            $string .= ' '.$key.'="'.str_replace('"', '\\"', trim((string)$value)).'"';
        }

        return trim($string);
    }

    protected function buffer(string $function, array|string $value): void
    {
        $this->buffer = ['function' => $function, 'value' => $value];
    }

    protected function attributesBuffered(bool $flush = false): array
    {
        $attributes = is_null($this->buffer['function'] ?? null) === false
            ? Arr::{$this->buffer['function']}($this->attributes, $this->buffer['value'] ?? [])
            : $this->attributes;

        if ($flush) {
            $this->buffer = [];
        }

        return $attributes;
    }
}
