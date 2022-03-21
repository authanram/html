<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Plugins\TrimRendererPlugin;

class Element extends AbstractElement
{
    use Concerns\HasRenderer;

    protected string $tag;
    protected array $attributes;
    protected array $contents;

    public function __construct(?string $tag = null, ?array $attributes = null, ?array $contents = null)
    {
        $this
            ->setTag($tag ?? $this->getTag())
            ->setAttributes($attributes ?? $this->getAttributes())
            ->setContents($contents ?? $this->getContents());
    }

    public function boot(): static
    {
        return $this;
    }

    public function getTag(): string
    {
        return $this->tag ?? 'div';
    }

    public function getAttributes(): array
    {
        return $this->attributes ?? [];
    }

    public function getContents(): array
    {
        return $this->contents ?? [];
    }

    public function getRenderer(): AbstractRenderer
    {
        $this->renderer ??= (new Renderer())
            ->addPlugin(TrimRendererPlugin::class);

        return $this->renderer;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function setContents(array $contents): static
    {
        $this->contents = $contents;

        return $this;
    }
}
