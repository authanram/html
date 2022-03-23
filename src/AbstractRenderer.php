<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRenderer
{
    abstract public function withPlugins(array $plugins): static;

    abstract public function render(AbstractElement $element): string;
}
