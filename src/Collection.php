<?php

declare(strict_types=1);

namespace Authanram\Html;

use BadMethodCallException;
use Illuminate\Support\Collection as IlluminateCollection;
use TypeError;

/**
 * @method array all()
 * @method array toArray()
 * @method mixed get(string $key)
 * @method self add(string $key, mixed $value)
 * @method self except(array|string $keys)
 * @method self forget(array|string $keys)
 * @method self merge(array $items)
 * @method self only(array|string $keys)
 * @method self set(string $key, mixed $value)
 */
abstract class Collection
{
    protected static array $collectionMethods = [
        'all',
        'except',
        'forget',
        'get',
        'merge',
        'only',
        'toArray',
    ];

    protected static array $collectionMethodsResolving = [
        'all',
        'avg',
        'contains',
        'containsOneItem',
        'count',
        'doesntContain',
        'first',
        'firstOrFail',
        'get',
        'getIterator',
        'getOrPut',
        'has',
        'hasAny',
        'implode',
        'isEmpty',
        'isNotEmpty',
        'join',
        'last',
        'median',
        'mode',
        'offsetExists',
        'offsetGet',
        'search',
        'sole',
        'toArray',
        'toJson',
    ];

    protected static array $methodsVoid = [
        'offsetSet',
        'offsetUnset',
    ];

    protected IlluminateCollection $items;

    public static function make(array $items = []): static
    {
        return new static($items);
    }

    public function __construct(array $items = [])
    {
        $this->items = new IlluminateCollection($items);
    }

    public function __call(string $name, array $arguments): mixed
    {
        $methods = array_merge(
            static::$collectionMethods,
            static::$methodsVoid,
        );

        $methodForward = 'forward'.ucfirst($name);

        if (array_key_exists($name, $methods) === false
            && in_array($name, $methods, true) === false
            && method_exists($this, $methodForward) === false
        ) {
            throw new BadMethodCallException(
                'Call to undefined method '.static::class.'::'.$name.'()',
            );
        }

        $result = method_exists($this, $methodForward)
            ? $this->{$methodForward}(...$arguments)
            : $this->items->{$name}(...$arguments);

        if (in_array($name, static::$methodsVoid, true)) {
            return null;
        }

        if (in_array($name, static::$collectionMethodsResolving, true)) {
            return $result;
        }

        $this->items = $result;

        return $this;
    }

    public function forwardSet(string|int $key, mixed $value): IlluminateCollection
    {
        return $this->items->put($key, $value);
    }

    public function forwardAdd(string|int $key, mixed $value): IlluminateCollection
    {
        if ($this->items->keys()->contains($key) === false) {
            $this->items = $this->items->merge([$key => $value]);
        }

        return $this->items;
    }

    public function pipe(callable $callback): IlluminateCollection
    {
        $result = $callback($this);

        if (is_object($result) && is_subclass_of($result, __CLASS__)) {
            return $result->items;
        }

        throw new TypeError(sprintf(
            '%s: Return value must be of type %s, %s returned',
            static::class.'::'.__FUNCTION__.'()',
            static::class,
            gettype($result),
        ));
    }

    public function flush(): static
    {
        $this->items = new IlluminateCollection();

        return $this;
    }
}
