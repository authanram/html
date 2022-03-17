<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Element;

class TestElement extends Element
{
    protected string $tag = 'span';

    protected array $attributes = [
        'class' => 'purple',
    ];

    protected array $contents = [
        'foo: ',
        ['span', ['data-x' => 'bar'], ['qux']],
    ];
}
