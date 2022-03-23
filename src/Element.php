<?php

declare(strict_types=1);

namespace Authanram\Html;

class Element extends AbstractElement
{
    use HasRenderer;

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

        $this->attributes = $attributes ?? $this->getAttributes()->toArray();

        $this->contents = $contents ?? $this->getContents();

        $this->renderer = $this->renderer();
    }

    public function getTag(): string
    {
        return $this->tag ??= static::$tagDefault;
    }

    public function getAttributes(): Attributes
    {
        return new Attributes($this->attributes ??= []);
    }

    public function getContents(): array
    {
        return $this->contents ??= [];
    }

    public function getRenderer(): AbstractRenderer
    {
        return $this->renderer ??= (new Renderer());
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function setAttributes(Attributes|array $attributes): static
    {
        $this->attributes = is_array($attributes) === false
            ? $attributes->toArray()
            : $attributes;

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
        return $this->getAttributes()->toArray();
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
