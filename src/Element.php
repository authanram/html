<?php

declare(strict_types=1);

namespace Authanram\Html;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class Element
{
    public static string $defaultTag = 'div';

    public AbstractRenderer|string $renderer = Renderer::class;

    protected string $tag;

    protected Collection $attributes;

    protected Collection $contents;

    public function __construct(?string $tag = null, ?array $attributes = null, ?array $contents = null)
    {
        $this->tag ??= $tag ?? static::$defaultTag;

        $this->attributes ??= new Collection($attributes);

        $this->contents ??= new Collection($contents);
    }

    public function setRenderer(AbstractRenderer|string $renderer): static
    {
        if (is_subclass_of($renderer, AbstractRenderer::class) === false) {
            throw new InvalidArgumentException('Renderer must extend: '.AbstractRenderer::class);
        }

        $this->renderer = $renderer;

        return $this;
    }

    public function render(AbstractRenderer|string|null $renderer = null): string
    {
        if (is_null($renderer) === false) {
            $this->setRenderer($renderer);
        }

        if (is_string($this->renderer)) {
            $this->renderer = new $this->renderer;
        }

        return $this->renderer->render(...$this->toArray());
    }

    public function toArray(): array
    {
        return [
            'tag' => $this->tag,
            'attributes' => $this->attributes->toArray(),
            'contents' => $this->contents->toArray(),
        ];
    }
}
