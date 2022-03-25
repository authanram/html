<?php

declare(strict_types=1);

namespace Authanram\Html;

if (function_exists('element') === false) {
    function element(string $tag, array|string $contents = []): Element {
        return Element::parse($tag, $contents);
    }
}
