# Laravel Settings

A simple and elegant settings management system for Laravel applications.

![Laravel Settings](https://img.shields.io/badge/Laravel-Settings-red.svg) 
![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-1.0-green.svg)

## ✨ Features

- 🚀 Easy to install and use
- 🔒 Secure and optimized for performance
- 🌐 Full RTL support and Arabic localization
- 💾 Cached settings for better performance
- 🎨 Beautiful admin UI with Tailwind CSS
- 🧩 Organized settings by categories
- 🔄 Simple API to get/set settings in your application

## 📦 Installation

You can install the package via composer:

```bash
composer require mt-settings/laravel-settings
```

## 🔧 Setup

### Quick Installation

Run the installation command:

```bash
php artisan settings:install
```

This will:
- Publish the configuration file
- Publish the migrations
- Publish the views
- Ask if you want to run migrations
- Attempt to add the settings link to your admin sidebar

### Manual Installation

1. Publish the configuration:

```bash
php artisan vendor:publish --tag=laravel-settings-config
```

2. Publish the migrations:

```bash
php artisan vendor:publish --tag=laravel-settings-migrations
```

3. Publish the views (optional):

```bash
php artisan vendor:publish --tag=laravel-settings-views
```

4. Run the migrations:

```bash
php artisan migrate
```

## 📝 Usage

### In Controllers

```php
use MtSettings\LaravelSettings\Facades\Settings;

// Get a setting with a default value
$siteName = Settings::get('site_name', 'Default Site Name');

// Set a setting
Settings::set('maintenance_mode', true);

// Check if a setting exists
if (Settings::has('meta_title')) {
    // Do something
}

// Get all settings
$allSettings = Settings::getAll();

// Clear settings cache
Settings::clearCache();
```

### In Blade Templates

```blade
{{-- Get a setting with a default value --}}
<title>{{ Settings::get('site_name', config('app.name')) }}</title>

{{-- Check if a setting exists and use it --}}
@if(Settings::has('meta_description'))
    <meta name="description" content="{{ Settings::get('meta_description') }}">
@endif

{{-- Use a setting with a condition --}}
@if(Settings::get('maintenance_mode', false))
    <div class="alert alert-warning">
        The site is currently in maintenance mode
    </div>
@endif
```

### Admin Panel

The package includes a complete admin panel for managing settings. By default, it's accessible at:

```
/admin/settings
```

You can customize the route prefix and middleware in the configuration file.

## ⚙️ Configuration

You can customize the package behavior by modifying the published configuration file:

```php
// config/settings.php

return [
    'route_prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    // ...
];
```

## 📋 Available Settings

The package comes with predefined settings categories:

| Category | Settings |
|----------|----------|
| **General** | site_name, items_per_page, maintenance_mode |
| **SEO** | meta_title, meta_description, meta_keywords |
| **Contact** | contact_email, phone_number, address |
| **Social Media** | facebook_url, twitter_url, instagram_url, linkedin_url |
| **Advanced** | cache_enabled, cache_expiration, google_analytics_id, custom_header_scripts |

### General
- **site_name**: Your site name
- **items_per_page**: Default number of items per page
- **maintenance_mode**: Enable/disable maintenance mode

### SEO
- **meta_title**: Default meta title
- **meta_description**: Default meta description
- **meta_keywords**: Default meta keywords

### Contact
- **contact_email**: Contact email address
- **phone_number**: Contact phone number
- **address**: Physical address

### Social Media
- **facebook_url**: Facebook page URL
- **twitter_url**: Twitter profile URL
- **instagram_url**: Instagram profile URL
- **linkedin_url**: LinkedIn profile URL

### Advanced
- **cache_enabled**: Enable/disable settings cache
- **cache_expiration**: Cache expiration time in seconds
- **google_analytics_id**: Google Analytics tracking ID
- **custom_header_scripts**: Custom scripts to include in the header

## 🎨 Customization

### Views

If you published the views, you can customize them at:

```
resources/views/vendor/laravel-settings
```

### Translations

The package supports translations through Laravel's localization system. To publish translations:

```bash
php artisan vendor:publish --tag=laravel-settings-translations
```

## 🧪 Testing

```bash
composer test
```

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.