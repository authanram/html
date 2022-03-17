<?php

declare(strict_types=1);

namespace Authanram\Html\Tests;

use Authanram\Html\Providers\HtmlServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            HtmlServiceProvider::class,
        ];
    }
}
