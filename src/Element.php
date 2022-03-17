<?php

declare(strict_types=1);

namespace Authanram\Html;

use InvalidArgumentException;

class Element
{
    public static string $defaultTag = 'div';

    protected string $tag;

    protected array $attributes;

    protected array $contents;

    protected AbstractRenderer|string $renderer = Renderer::class;

    public function __construct(?string $tag = null, ?array $attributes = null, ?array $contents = null)
    {
        $this->tag ??= $tag;

        $this->attributes ??= $attributes;

        $this->contents ??= $contents;
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
            'attributes' => $this->attributes,
            'contents' => $this->contents,
        ];
    }
}
