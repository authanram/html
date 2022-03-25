<?php

declare(strict_types=1);

namespace Authanram\Html;

use Spatie\HtmlElement\AbbreviationParser as SpatieAbbreviationParser;

class AbbreviationParser
{
    public static function parse(string $tag, array $contents = []): Element
    {
        $tags = preg_split('/ \s* > \s* /x', $tag, 2);

        $parsed = static::parseTag($tags[0]);

        $children = [];

        $texts = [];

        foreach ($contents as $key => $value) {
            if (is_string($key)) {
                continue;
            }

            $texts[] = $value;
            unset($contents[$key]);
        }

        if (isset($tags[1])) {
            $children[] = static::parse($tags[1], $contents);
        }

        if (isset($parsed['attributes']['text'])) {
            $children[] = $contents[$parsed['attributes']['text']]
                ?? $parsed['attributes']['text'];
        }

        unset($parsed['attributes']['text']);

        $children = array_merge($children, $texts);

        return new Element($parsed['tag'], $parsed['attributes'], $children);
    }

    public static function parseTag(string $tag): array
    {
        $parsed = SpatieAbbreviationParser::parse(
            preg_replace('/\s*/m', '', $tag),
        );

        return [
            'tag' => $parsed['element'],
            'attributes' => array_merge(
                $parsed['attributes'],
                ['class' => implode(' ', $parsed['classes'])],
            ),
        ];
    }
}
