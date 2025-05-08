<?php

namespace MtSettings\LaravelSettings;

use Illuminate\Support\ServiceProvider;
use MtSettings\LaravelSettings\Models\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the settings singleton
        $this->app->singleton('settings', function ($app) {
            return new Setting();
        });
        
        // Register migrations
        $this->publishes([
            __DIR__ . '/database/migrations/create_settings_table.php.stub' => 
                $this->getMigrationFileName('create_settings_table.php'),
        ], 'settings-migrations');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // No views, routes, or additional resources
    }
    
    /**
     * Get migration filename.
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');
        
        return database_path("migrations/{$timestamp}_{$migrationFileName}");
    }
}