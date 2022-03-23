<?php

declare(strict_types=1);

namespace Authanram\Html;

use BadMethodCallException;
use Illuminate\Support\Collection as IlluminateCollection;
use TypeError;

/**
 * @method array all()
 * @method array toArray()
 * @method self merge(array $items)
 */
abstract class Collection
{
    protected static array $collectionMethods = [];

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
            ['all', 'toArray', 'merge'],
            static::$collectionMethods,
            static::$methodsVoid,
        );

        if (array_key_exists($name, $methods) === false
            && in_array($name, $methods, true) === false
        ) {
            throw new BadMethodCallException(
                'Call to undefined method '.static::class.'::'.$name.'()',
            );
        }

        $result = $this->items->{$name}(...$arguments);

        if (in_array($name, static::$methodsVoid, true)) {
            return null;
        }

        if (in_array($name, static::$collectionMethodsResolving, true)) {
            return $result;
        }

        $this->items = $result;

        return $this;
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
            is_object($result) ? $result::class : gettype($result),
        ));
    }

    public function flush(): static
    {
        $this->items = new IlluminateCollection();

        return $this;
    }
}
