<?php

declare(strict_types=1);

namespace Authanram\Html;

abstract class AbstractRendererPlugin
{
    abstract public function setElement(AbstractElement $element): static;

    abstract public function authorize(): bool;

    abstract public function handle(): AbstractElement;

    abstract public function render(string $html): string;
}
