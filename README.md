<div class="filament-hidden">

![Filament Hidden Action](https://raw.githubusercontent.com/jeffersongoncalves/filament-hidden-action/2.x/art/jeffersongoncalves-filament-hidden-action.png)

</div>

# Filament Hidden Action

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-hidden-action.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-hidden-action)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-hidden-action/fix-php-code-style-issues.yml?branch=1.x&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-hidden-action/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3A1.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-hidden-action.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-hidden-action)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/filament-hidden-action.svg?style=flat-square)](LICENSE.md)

This package provides a `HiddenAction` for Filament, allowing you to define actions that are not visible in the UI but can still be triggered programmatically or via keyboard shortcuts.

## Requirements

- PHP 8.2 or higher
- Filament 5.0

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/filament-hidden-action
```

## Usage

The `HiddenAction` can be used just like any other Filament Action, but it won't render any button or link in the UI. This is useful when you need to trigger an action programmatically or via a keyboard shortcut without showing it.

```php
use JeffersonGoncalves\Filament\HiddenAction\HiddenAction;

HiddenAction::make('hidden-action')
    ->action(function () {
        // Your logic here
    });
```

## Development

You can run code analysis and formatting using the following commands:

```bash
# Run static analysis
composer analyse

# Format code
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
