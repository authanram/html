<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\AbstractPlugin;

class TestPlugin extends AbstractPlugin
{
    public function render(string $value): string
    {
        return '<div data-testplugin>'.$value.'</div>';
    }
}
