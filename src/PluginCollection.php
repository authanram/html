<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

/**
 * @method self except(array|string $keys)
 */
final class PluginCollection extends Collection
{
    protected static array $collectionMethods = [
        'except',
    ];

    protected static array $collectionMethodsAuthorizing = [
        'merge',
    ];

    public static function authorize(array $items): void
    {
        foreach ($items as $item) {
            if (is_object($item) === false) {
                throw new InvalidArgumentException(sprintf(
                    'Expected instance of %s, got: %s (%s)',
                    AbstractRendererPlugin::class,
                    gettype($item),
                    $item,
                ));
            }

            if (is_subclass_of($item, AbstractRendererPlugin::class) === false) {
                throw new InvalidArgumentException(
                    $item.' must be a subclass of '.AbstractRendererPlugin::class,
                );
            }
        }
    }
}
