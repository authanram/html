<?php

declare(strict_types=1);

namespace Authanram\Html;

class AbbreviationParser extends \Spatie\HtmlElement\AbbreviationParser
{
    public static function parse(string $tag): array
    {
        $parsed = parent::parse(preg_replace('/\s*/m', '', $tag));

        return [
            'tag' => $parsed['element'],
            'attributes' => array_merge(
                $parsed['attributes'],
                ['class' => implode(' ', $parsed['classes'])],
            ),
        ];
    }
}
