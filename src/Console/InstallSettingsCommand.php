<?php

namespace MtSettings\LaravelSettings\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:install {--force : Force overwrite of existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Laravel Settings package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing Laravel Settings Package...');

        // Publish configuration
        $this->publishConfig();
        
        // Publish migrations
        $this->publishMigrations();
        
        $this->info('Laravel Settings Package installed successfully!');
        
        if ($this->confirm('Would you like to run the migrations now?', true)) {
            $this->call('migrate');
        }
        
        $this->info("Thank you for installing Laravel Settings Package!");
        $this->info("To access settings, visit: " . url(config('settings.route_prefix', 'admin') . '/settings'));
    }
    
    /**
     * Publish configuration file.
     */
    private function publishConfig()
    {
        $this->info('Publishing configuration...');
        
        if ($this->option('force') || !File::exists(config_path('settings.php'))) {
            $this->call('vendor:publish', [
                '--tag' => 'laravel-settings-config',
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->info('Config already exists. Use --force to overwrite.');
        }
    }
    
    /**
     * Publish migration files.
     */
    private function publishMigrations()
    {
        $this->info('Publishing migrations...');
        
        $this->call('vendor:publish', [
            '--tag' => 'laravel-settings-migrations',
            '--force' => $this->option('force'),
        ]);
    }
}