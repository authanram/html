<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Plugins\TrimRendererPlugin;

class Element extends AbstractElement
{
    use Concerns\HasRenderer;

    public static string $tagDefault = 'div';

    protected string $tag;

    protected array $attributes;

    protected array $contents;

    public static function make(
        ?string $tag = null,
        ?array $attributes = null,
        array|string|null $contents = null
    ): static {
        return new static($tag, $attributes, $contents);
    }

    public function __construct(
        ?string $tag = null,
        ?array $attributes = null,
        array|string|null $contents = null,
    ) {
        $contents = is_string($contents) ? [$contents] : $contents;

        $this->tag = $tag ?? $this->getTag();

        $this->attributes = $attributes ?? $this->getAttributes();

        $this->contents = $contents ?? $this->getContents();

        $this->renderer = $this->renderer();
    }

    public function getTag(): string
    {
        return $this->tag ??= static::$tagDefault;
    }

    public function getAttributes(): array
    {
        return $this->attributes ??= [];
    }

    public function getContents(): array
    {
        return $this->contents ??= [];
    }

    public function getRenderer(): AbstractRenderer
    {
        return $this->renderer ??= (new Renderer())
            ->addPlugin(TrimRendererPlugin::class);
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

    public function setContents(array|string ...$contents): static
    {
        foreach ($contents as $content) {
            $this->contents = is_string($content) ? [$content] : $content;
        }

        return $this;
    }

    public function tag(): string
    {
        return $this->getTag();
    }

    public function attributes(): array
    {
        return $this->getAttributes();
    }

    public function contents(): array
    {
        return $this->getContents();
    }

    public function renderer(): AbstractRenderer
    {
        return $this->getRenderer();
    }
}
