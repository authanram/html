<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Element;

class TestElementSelfClosing extends Element
{
    protected string $tag = 'img';

    protected array $attributes = [];
}
