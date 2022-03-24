<?php

declare(strict_types=1);

namespace Authanram\Html;

use Authanram\Html\Contracts\Renderable;
use Closure;

class RendererPlugin implements Contracts\RendererPlugin
{
    protected Renderable $element;

    protected array $callbacks = [];

    public function setCallbackHandle(Closure $callback): static
    {
        $this->callbacks['handle'] = $callback;

        return $this;
    }

    public function setCallbackRender(Closure $callback): static
    {
        $this->callbacks['render'] = $callback;

        return $this;
    }

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
        return isset($this->callbacks[__FUNCTION__])
            ? call_user_func($this->callbacks[__FUNCTION__], $this->element)
            : $this->element;
    }

    public function render(string $html): string
    {
        return isset($this->callbacks[__FUNCTION__])
            ? call_user_func($this->callbacks[__FUNCTION__], $html)
            : $html;
    }
}
