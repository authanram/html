<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Contracts\RendererPlugin as Contract;
use Authanram\Html\RendererPlugin;

class TestRenderPluginWithoutHandlers extends RendererPlugin implements Contract
{
}
