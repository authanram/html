# authanram/html

Painless html generation.

## Installation

You can install the package via composer.

```shell
composer require authanram/html
```

## Basic Usage Example

Here's an example of how it can be used in a very basic way:

```php
use Authanram\Html\Renderer;

$qux = [
    'tag' => 'a',
    'attributes' => [
        'href' => 'https://github.com/authanram',
        'class' => 'text-blue-600',
        'data-anchor' => true,
    ],
    'contents' => [
        'authanram at github.com'
    ],
];

Renderer::renderFromArray($qux);
```

`Renderer::renderFromArray($qux);` will return the following `string`:

```html
<a href="https://github.com/authanram" class="text-blue-600" data-anchor>
    authanram at github.com
</a>
```

### Nesting

```php
use Authanram\Html\Renderer;

$qux = [
    'tag' => 'p',
    'contents' => [
        [
            'tag' => 'a',
            'attributes' => [
                'class' => 'text-blue-600',
                'href' => 'https://github.com/authanram',
            ],
            'contents' => [
                [
                    'tag' => 'span',
                    'class' => 'semibold',
                    'contents' => [
                        ['authanram at github.com'],
                    ]
                ],
            ],
        ],
    ],
];

Renderer::renderFromArray($qux);
```

`Renderer::renderFromArray($qux);` will return the following `string`:

```html
<p>
    <a class="text-blue-600" href="https://github.com/authanram">
        <span class="semibold">
            authanram at github.com
        </span>
    </a>
</p>
```

## Class Based Usage

As you can see [here](https://github.com/authanram/html/blob/1e58bf82d16d06dde3b2860ab181cf7ebfb5e5a7/src/Renderer.php#L60),
we can achieve the same result using the static method `Authanram\Html\Element::make()`:

```php
use Authanram\Html\Element;

Element::make(
    'a',
    [
        'href' => 'https://gitub.com',
        'class' => 'text-blue-600',
    ],
    ['authanram at github.com'],
)->render();
```

## Abbreviation Based Usage

...

```php
use Authanram\Html\Element;

Element::parse('a.text-blue-600[href=https://gitub.com]')
    ->render();
```

## Credits

- [Daniel Seuffer](https://github.com/authanram)
- [and Contributors](https://github.com/authanram/html/graphs/contributors) &nbsp;❤️

## License

The MIT License (MIT). Please see [License File](https://github.com/authanram/html/blob/master/LICENSE.md)
for more information.

