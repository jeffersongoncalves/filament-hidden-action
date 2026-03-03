## Filament Hidden Action

Provides a `HiddenAction` for Filament that allows you to define actions that are not visible in the UI but can still be triggered programmatically or via keyboard shortcuts. The action renders as an HTML comment instead of a button.

### Installation

@verbatim
<code-snippet name="Install the plugin" lang="bash">
composer require jeffersongoncalves/filament-hidden-action
</code-snippet>
@endverbatim

### Usage

@verbatim
<code-snippet name="Create a hidden action" lang="php">
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('hidden-action')
    ->action(function () {
        // Your logic here
    });
</code-snippet>
@endverbatim

### With Keyboard Shortcut

@verbatim
<code-snippet name="Hidden action with keyboard shortcut" lang="php">
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('quick-save')
    ->keyBindings(['mod+s'])
    ->action(function () {
        // Save logic
    });
</code-snippet>
@endverbatim

### Features
- Extends `Filament\Actions\Action` -- supports all standard action methods (modals, forms, notifications, etc.)
- Renders as an HTML comment (`<!--Hidden Action - {hashed_name} -->`) instead of a button
- Can be triggered programmatically or via keyboard shortcuts (`keyBindings()`)
- No plugin registration needed -- just use `HiddenAction` directly in place of `Action`

### Architecture
- `HiddenAction` extends `Filament\Actions\Action` and overrides the view to `filament-hidden-action::components.hidden`
- `HiddenActionServiceProvider` extends `PackageServiceProvider` and registers views
- The view renders only an HTML comment with the MD5-hashed action name
- No `Plugin` class needed -- this is a standalone component, not a panel plugin

### Best Practices
- Use `HiddenAction` for actions that should only be triggered by keyboard shortcuts or programmatic calls
- Combine with `keyBindings()` for keyboard-accessible actions without UI clutter
- The action name is MD5-hashed in the rendered HTML comment for identification
- All standard `Action` methods work: `action()`, `requiresConfirmation()`, `form()`, `modalContent()`, etc.
