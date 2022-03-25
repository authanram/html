<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\AbbreviationParser;
use function Authanram\Html\element;

it('parses', function () {
    $element = element('div.blue[text=one] > span.red[text=two] > p.green[text=three]', [
        'one' => 'ONE',
        'two' => element('div.yellow[text=four]', [
            'four' => 'FOUR',
            'yellow',
        ]),
    ]);

    expect($element->render())->toEqual(
        '<div class="blue"><span class="red"><p class="green">three</p><div class="yellow">FOURyellow</div></span>ONE</div>',
    );
});

it('parses tag', function (): void {
    $expectation = [
        'tag' => 'div',
        'attributes' => [
            'x-data' => '{foo:\'bar\',qux:true}',
            'style' => 'display:none;',
            'class' => 'bg-green hover:bg-red',
            'id' => 'el-id',
        ],
    ];

    $result = AbbreviationParser::parseTag(
        'div#el-id.bg-green.hover:bg-red[x-data={foo:\'bar\',qux:true}][style=display:none;]',
    );

    expect($result)->toEqual($expectation);

    $result = AbbreviationParser::parseTag('
        div
        #el-id
        .bg-green.hover:bg-red
        [x-data={foo:\'bar\',qux:true}]
        [style=display:none;]
    ');

    expect($result)->toEqual($expectation);
});
