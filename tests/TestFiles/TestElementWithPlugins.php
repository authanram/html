<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Element;

class TestElementWithPlugins extends Element
{
    public static array $plugins = [
        TestPlugin::class,
    ];

    protected string $tag = 'div';

    protected array $contents = ['content'];
}
