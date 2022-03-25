<?php

declare(strict_types=1);

namespace Authanram\Html\Tests\TestFiles;

use Authanram\Html\Contracts\Renderable;
use Authanram\Html\Contracts\RendererPlugin as Contract;
use Authanram\Html\RendererPlugin;

class TestRenderPlugin extends RendererPlugin implements Contract
{
    public function setElement(Renderable $element): static
    {
        $this->element = $element;

        return $this;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function handle(): Renderable
    {
        return $this->element
            ->setTag('p')
            ->setAttributes([
                'data-handle' => true,
            ]);
    }

    public function render(string $html): string
    {
        return '<div data-render>'.$html.'</div>';
    }
}
