<?php

use Illuminate\Support\Facades\Blade;
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

it('loads every class it ships', function (string $class) {
    expect(class_exists($class) || interface_exists($class) || trait_exists($class))->toBeTrue();
})->with([
    ['JeffersonGoncalves\\Filament\\HiddenAction\\HiddenAction'],
    ['JeffersonGoncalves\\Filament\\HiddenAction\\HiddenActionServiceProvider'],
]);

it('compiles every Blade view it ships', function (string $file) {
    expect(Blade::compileString((string) file_get_contents(__DIR__.'/../../'.$file)))->toBeString();
})->with([
    ['resources/views/components/hidden.blade.php'],
]);

it('builds HiddenAction', function () {
    expect(HiddenAction::make('subject')->getName())->toBe('subject');
});
