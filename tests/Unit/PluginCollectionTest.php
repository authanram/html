<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use Authanram\Html\Collections\PluginCollection;
use Authanram\Html\Tests\TestFiles;

beforeEach(function () {
    $this->collection = PluginCollection::make();
});

it('adds items', function (): void {
    $this->collection
        ->add(new TestFiles\TestRendererPluginOne())
        ->add([
            new TestFiles\TestRendererPluginTwo(),
            new TestFiles\TestRendererPluginThree(),
        ]);

    expect($this->collection->toArray())
        ->toEqual([
            new TestFiles\TestRendererPluginOne(),
            new TestFiles\TestRendererPluginTwo(),
            new TestFiles\TestRendererPluginThree(),
        ]);
});

it('prepends item', function (): void {
    $this->collection->add(new TestFiles\TestRendererPluginOne());

    $this->collection
        ->prepend([
            new TestFiles\TestRendererPluginTwo(),
            new TestFiles\TestRendererPluginThree(),
        ]);

    expect($this->collection->toArray())
        ->toEqual([
            new TestFiles\TestRendererPluginTwo(),
            new TestFiles\TestRendererPluginThree(),
            new TestFiles\TestRendererPluginOne(),
        ]);
});
