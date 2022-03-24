<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Element;
use Authanram\Html\RendererPlugin;

it('renders', function (): void {
    $plugin = (new RendererPlugin())
        ->setElement(Element::make())
        ->setCallbackHandle(
            fn (Element $element) => $element
                ->setTag('p')
                ->setAttributes(['callback-handle' => true]),
        )
        ->setCallbackRender(
            fn (string $html) => "<div callback-render>$html</div>",
        );

    $html = $plugin->handle()->setContents(['foo'])->render();

    $result = $plugin->render($html);

    expect($result)->toEqual(
        '<div callback-render><p callback-handle>foo</p></div>',
    );
});
