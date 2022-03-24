<?php

declare(strict_types=1);

namespace Authanram\Html\Collections;

use Authanram\Html\CollectionProxy;
use Authanram\Html\Contracts\RendererPlugin;
use InvalidArgumentException;

/**
 * @method self add(RendererPlugin $plugin)
 * @method self except(array|string $keys)
 * @method self prepend(RendererPlugin $plugin)
 */
final class PluginCollection extends CollectionProxy
{
    protected static array $collectionMethods = [
        'except',
        'prepend',
    ];

    public static function authorize(array $items): void
    {
        foreach ($items as $item) {
            if (is_object($item) === false) {
                throw new InvalidArgumentException(sprintf(
                    'Expected instance of %s, got: %s (%s)',
                    RendererPlugin::class,
                    gettype($item),
                    $item,
                ));
            }

            if (is_subclass_of($item, RendererPlugin::class) === false) {
                throw new InvalidArgumentException(
                    $item.' must be a subclass of '.RendererPlugin::class,
                );
            }
        }
    }
}
