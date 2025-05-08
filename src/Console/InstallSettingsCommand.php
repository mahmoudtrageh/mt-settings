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
        
        // Publish views
        $this->publishViews();
        
        // Add to sidebar menu (optional)
        if ($this->confirm('Would you like to add Settings to your admin sidebar menu?', true)) {
            $this->addToSidebar();
        }
        
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
    
    /**
     * Publish view files.
     */
    private function publishViews()
    {
        $this->info('Publishing views...');
        
        if ($this->option('force') || !File::isDirectory(resource_path('views/vendor/laravel-settings'))) {
            $this->call('vendor:publish', [
                '--tag' => 'laravel-settings-views',
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->info('Views already exists. Use --force to overwrite.');
        }
    }
    
    /**
     * Add to sidebar menu (if exists).
     */
    private function addToSidebar()
    {
        $sidebarPath = resource_path('views/admin/partials/sidebar.blade.php');
        
        if (File::exists($sidebarPath)) {
            $sidebar = File::get($sidebarPath);
            
            // Check if settings menu item already exists
            if (strpos($sidebar, 'settings.index') !== false) {
                $this->info('Settings menu item already exists in sidebar.');
                return;
            }
            
            // Add settings menu item snippet
            $settingsMenuItem = <<<'EOT'
<!-- Settings -->
<li class="nav-item">
    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>إعدادات النظام</p>
    </a>
</li>
EOT;
            
            // Find where to insert the menu item
            $insertPosition = strrpos($sidebar, '</ul>');
            
            if ($insertPosition !== false) {
                $newSidebar = substr_replace(
                    $sidebar,
                    $settingsMenuItem . PHP_EOL . PHP_EOL . '    ',
                    $insertPosition,
                    0
                );
                
                File::put($sidebarPath, $newSidebar);
                $this->info('Settings menu item added to sidebar.');
            } else {
                $this->warn('Could not automatically add to sidebar. Please add manually.');
            }
        } else {
            $this->warn('Sidebar file not found. Please add settings menu item manually.');
        }
    }
}