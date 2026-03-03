---
name: filament-hidden-action-development
description: Build and work with Filament Hidden Action features, including invisible UI actions, keyboard shortcuts, and programmatic action triggering.
---

# Filament Hidden Action Development

## When to use this skill

Use this skill when:
- Creating actions that should not render any visible UI element (button, link)
- Adding keyboard shortcut-triggered actions to Filament pages or resources
- Triggering actions programmatically without displaying them in the interface
- Working with the `HiddenAction` or `HiddenActionServiceProvider` classes
- Needing an action that participates in Filament's action lifecycle but remains invisible

## Package Overview

- **Package**: `jeffersongoncalves/filament-hidden-action`
- **Namespace**: `JeffersonGoncalves\Filament\HiddenAction`
- **Dependencies**: `filament/actions:^5.0`, `spatie/laravel-package-tools:^1.14.0`
- **Service Provider**: `JeffersonGoncalves\Filament\HiddenAction\HiddenActionServiceProvider`
- **Note**: This is a standalone component, not a Filament panel plugin -- no `Plugin` class or panel registration needed

## Version Compatibility

| Branch | Filament | PHP |
|--------|----------|-----|
| 2.x | 5.x | ^8.2 |

## Configuration

### Basic Usage

No plugin registration is required. Simply use `HiddenAction` in place of `Action`:

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('hidden-action')
    ->action(function () {
        // Your logic here
    });
```

### With Keyboard Shortcut

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('quick-save')
    ->keyBindings(['mod+s'])
    ->action(function () {
        // Save logic
    });
```

### With Confirmation Modal

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('dangerous-action')
    ->keyBindings(['mod+shift+d'])
    ->requiresConfirmation()
    ->action(function () {
        // Dangerous logic
    });
```

### With Form Modal

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;
use Filament\Forms\Components\TextInput;

HiddenAction::make('quick-note')
    ->keyBindings(['mod+n'])
    ->form([
        TextInput::make('note')
            ->required(),
    ])
    ->action(function (array $data) {
        // Handle form data
    });
```

## Architecture

### HiddenAction Class

The `HiddenAction` extends `Filament\Actions\Action` and overrides the default view:

```php
namespace JeffersonGoncalves\Filament\HiddenAction;

use Filament\Actions\Action;

class HiddenAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultView('filament-hidden-action::components.hidden');
    }

    public function getExtraViewData(): array
    {
        return [
            'name' => md5($this->getName()),
        ];
    }
}
```

Key implementation details:
- `setUp()` sets the default view to `filament-hidden-action::components.hidden`
- `getExtraViewData()` passes the MD5-hashed action name to the view
- All parent `Action` methods are available (modals, forms, notifications, key bindings, etc.)

### Hidden View (`components/hidden.blade.php`)

The view renders only an HTML comment:

```blade
@props(['name' => null])
<!--Hidden Action - {{ $name }} -->
```

This ensures the action exists in the DOM for Filament's JavaScript to wire up (keyboard shortcuts, Livewire calls) but is completely invisible to the user.

### Service Provider (`HiddenActionServiceProvider`)

```php
namespace JeffersonGoncalves\Filament\HiddenAction;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HiddenActionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-hidden-action')
            ->hasViews();
    }
}
```

The service provider only registers views -- no config, migrations, or translations.

## Usage Contexts

### In Page Header Actions

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

protected function getHeaderActions(): array
{
    return [
        HiddenAction::make('refresh-data')
            ->keyBindings(['mod+r'])
            ->action(fn () => $this->refreshData()),
    ];
}
```

### In Table Actions

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

$table->actions([
    HiddenAction::make('quick-view')
        ->action(fn ($record) => $this->viewRecord($record)),
]);
```

### In Form Actions

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('auto-fill')
    ->keyBindings(['mod+shift+f'])
    ->action(function ($component) {
        // Auto-fill logic
    });
```

## Troubleshooting

### Action not triggering via keyboard shortcut
**Cause**: The `keyBindings()` method may not be configured, or the Filament JavaScript is not picking up the hidden element.
**Solution**: Ensure the `keyBindings()` method is called on the `HiddenAction`. The action must be registered in a context where Filament processes actions (header actions, table actions, etc.).

### Action renders visible content
**Cause**: The custom view is not being loaded.
**Solution**: Ensure the `HiddenActionServiceProvider` is registered and the views are published. Run `php artisan view:clear` to clear cached views.

### Action modal not appearing
**Cause**: Even though the action is hidden, modals should still work when triggered.
**Solution**: Verify the action is properly wired to Livewire. The HTML comment must be within a Livewire component's rendered output for the action system to work.
