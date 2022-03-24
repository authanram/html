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
 * @method self prepend(mixed $value, string|int $key = null)
 */
abstract class CollectionProxy
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

    protected static array $collectionMethodsVoid = [
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
            ['add', 'all', 'toArray', 'merge'],
            static::$collectionMethods,
            static::$collectionMethodsVoid,
        );

        if (array_key_exists($name, $methods) === false
            && in_array($name, $methods, true) === false
        ) {
            throw new BadMethodCallException(
                'Call to undefined method '.static::class.'::'.$name.'()',
            );
        }

        $result = $this->items->{$name}(...$arguments);

        if (method_exists(static::class, 'authorize')) {
            static::authorize(is_array($result) ? $result : $result->all(), $name);
        }

        if (in_array($name, static::$collectionMethodsVoid, true)) {
            return null;
        }

        if (in_array($name, static::$collectionMethodsResolving, true)) {
            return $result;
        }

        $this->items = $result;

        return $this;
    }

    public function flush(): static
    {
        $this->items = new IlluminateCollection();

        return $this;
    }
}
