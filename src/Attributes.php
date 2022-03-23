<?php

declare(strict_types=1);

namespace Authanram\Html;

use Illuminate\Support\Collection;
use TypeError;

class Attributes
{
    protected Collection $attributes;

    protected array $buffer;

    public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    public function __construct(array $attributes = [])
    {
        $this->attributes = new Collection($attributes);
    }

    public function get(string|int $key, mixed $default = null): mixed
    {
        return $this->attributes->get((string)$key, $default);
    }

    public function set(string|int $key, string|float|int|bool $value = null): static
    {
        return $this->forward('replace', [[(string)$key => $value]]);
    }

    public function getAttributes(): array
    {
        return $this->attributes->toArray();
    }

    public function setAttributes(array $attributes): static
    {
        $this->attributes = new Collection($attributes);

        return $this;
    }

    public function add(string $key, array|string|int|bool $value = null): static
    {
        return $this->forward('put', [$key, $value]);
    }

    public function merge(array $attributes): static
    {
        return $this->forward(__FUNCTION__, [$attributes]);
    }

    public function except(array|string|int $keys): static
    {
        return $this->forward(__FUNCTION__, [$keys]);
    }

    public function only(array|string|int $keys): static
    {
        return $this->forward(__FUNCTION__, [$keys]);
    }

    public function forget(array|string|int $keys): static
    {
        return $this->forward(__FUNCTION__, [$keys]);
    }

    public function pipe(callable $callback): static
    {
        $result = $callback($this);

        if (is_object($result) && $result::class === __CLASS__) {
            $this->attributes = $result->attributes;

            return $this;
        }

        throw new TypeError(sprintf(
            '%s: Return value must be of type %s, %s returned',
            __METHOD__.'()',
            __CLASS__,
            gettype($result),
        ));
    }

    public function flush(): static
    {
        $this->attributes = new Collection();

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes->toArray();
    }

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

    protected function forward(string $function, array $args): static
    {
        $this->attributes = $this->attributes->{$function}(...$args);

        return $this;
    }
}
