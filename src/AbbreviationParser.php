<?php

declare(strict_types=1);

namespace Authanram\Html;

class AbbreviationParser extends \Spatie\HtmlElement\AbbreviationParser
{
    public static function parse(string $tag): array
    {
        $parsed = parent::parse($tag);

        return [
            'tag' => trim($parsed['element']),
            'attributes' => array_merge(
                $parsed['attributes'],
                ['class' => trim(implode(' ', $parsed['classes']))],
            ),
        ];
    }
}
