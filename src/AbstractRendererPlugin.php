<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRendererPlugin
{
    abstract public function setElement(AbstractElement $element): static;

    abstract public function authorize(AbstractElement $element): bool;

    abstract public function handle(AbstractElement $element): AbstractElement;

    abstract public function render(string $html): string;
}
