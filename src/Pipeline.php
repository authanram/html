<?php

declare(strict_types=1);

namespace Authanram\Html;

class Pipeline
{
    protected mixed $passable = null;

    protected array $pipes = [];

    public function send(mixed $passable): static
    {
        $this->passable = $passable;

        return $this;
    }

    public function through(array $pipes): static
    {
        $this->pipes = $pipes;

        return $this;
    }

    public function process(): mixed
    {
        $next = fn (mixed $passable) => fn () => $passable;

        $carry = $next($this->passable);

        /** @var Pipe $pipe */
        foreach ($this->pipes as $pipe) {
            $carry = (new $pipe())->handle($carry(), $next);
        }

        return $carry();
    }
}
