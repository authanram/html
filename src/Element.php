<?php

declare(strict_types=1);

namespace Authanram\Html;

class Element extends AbstractElement
{
    public static string $defaultTag = 'div';

    protected string $tag;
    protected array $attributes;
    protected array $contents;

    public function __construct(?string $tag = null, ?array $attributes = null, ?array $contents = null)
    {
        $this->tag = $tag ?? $this->tag ?? static::$defaultTag;
        $this->attributes = $attributes ?? $this->attributes ?? [];
        $this->contents = $contents ?? $this->contents ?? [];
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getContents(): array
    {
        return $this->contents;
    }
}
