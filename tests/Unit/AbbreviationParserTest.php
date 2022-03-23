<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\AbbreviationParser;

it('parses', function (): void {
    $expectation = [
        'tag' => 'div',
        'attributes' => [
            'x-data' => '{foo:\'bar\',qux:true}',
            'style' => 'display:none;',
            'class' => 'bg-green hover:bg-red',
            'id' => 'el-id',
        ],
    ];

    $result = AbbreviationParser::parse(
        'div#el-id.bg-green.hover:bg-red[x-data={foo:\'bar\',qux:true}][style=display:none;]',
    );

    expect($result)->toEqual($expectation);

    $result = AbbreviationParser::parse('
        div
        #el-id
        .bg-green.hover:bg-red
        [x-data={foo:\'bar\',qux:true}]
        [style=display:none;]
    ');

    expect($result)->toEqual($expectation);
});
