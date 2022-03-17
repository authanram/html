<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRenderer
{
    abstract public function render(AbstractElement $element): string;
}
