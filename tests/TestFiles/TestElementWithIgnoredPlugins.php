<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Element;

class TestElementWithIgnoredPlugins extends Element
{
    public static array $pluginsIgnore = [
        TestPlugin::class,
    ];

    protected string $tag = 'div';

    protected array $contents = [
        ['tag' => 'span', 'attributes' => [], 'contents' => [TestElement::class]],
    ];
}
