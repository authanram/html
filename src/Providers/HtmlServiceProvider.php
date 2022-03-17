<?php

declare(strict_types=1);

namespace Authanram\Html\Providers;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningUnitTests() === false) {
            return;
        }

        $this->loadViewsFrom(__DIR__.'/../../tests/TestFiles/views', 'html');
    }
}
