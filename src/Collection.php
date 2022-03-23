<?php

declare(strict_types=1);

namespace Authanram\Html;

use BadMethodCallException;
use Illuminate\Support\Collection as IlluminateCollection;
use InvalidArgumentException;
use TypeError;

/**
 * @method array toArray()
 * @method mixed get(string|int $key)
 * @method self except(array|string $keys)
 * @method self forget(array|string $keys)
 * @method self merge(array $items)
 * @method self only(array|string $keys)
 */
abstract class Collection
{
    protected static array $collectionMethods = [];

    protected static array $collectionsMethodsDefault = [
        'add',
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

    protected IlluminateCollection $attributes;

    public static function make(array $items = []): static
    {
        return new static($items);
    }

    public function __construct(array $attributes = [])
    {
        if (count($attributes) && array_is_list($attributes)) {
            throw new InvalidArgumentException('$attributes must be an map');
        }

        $this->attributes = new IlluminateCollection($attributes);
    }

    public function __call(string $name, array $arguments): mixed
    {
        $methods = array_merge(
            static::$collectionMethods,
            static::$collectionsMethodsDefault,
        );

        $methodsCombined = array_merge(
            $methods,
            static::$methodsVoid,
        );

        if (array_key_exists($name, $methodsCombined) === false
            && in_array($name, $methodsCombined, true) === false
        ) {
            throw new BadMethodCallException(
                'Call to undefined method '.static::class.'::'.$name.'()',
            );
        }

        $result = $this->attributes->{$name}(...$arguments);

        if (in_array($name, static::$methodsVoid, true)) {
            return null;
        }

        if (in_array($name, static::$collectionMethodsResolving, true)) {
            return $result;
        }

        $this->attributes = $result;

        return $this;
    }

    public function set(string|int $key, mixed $value): static
    {
        $this->attributes = $this->attributes->merge([$key => $value]);

        return $this;
    }

    public function add(string|int $key, mixed $value): static
    {
        $this->attributes = $this->attributes->merge([$key => $value]);

        return $this;
    }

    public function pipe(callable $callback): static
    {
        $result = $callback($this);

        if (is_object($result) && is_subclass_of($result, __CLASS__)) {
            $this->attributes = $result->attributes;

            return $this;
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
        $this->attributes = new IlluminateCollection();

        return $this;
    }
}
