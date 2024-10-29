<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\Window;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        // Check if the migrations table exists and if users table is empty
        if ($this->shouldSeedDatabase()) {
            $this->runMigrations();
            $this->runDatabaseSeeding();
        }

        Menu::new()
            ->fileMenu()
            ->windowMenu()
            ->viewMenu()
            ->editMenu()
            ->submenu(
                'Help',
                Menu::new()
                    ->link('https://docs.flightadmin.info', 'Documentation')
                    ->separator()
                    ->label('Sign Out')
            )
            ->appMenu()
            ->register();

        Window::open()
            ->width(1500)
            ->height(800)
            ->minWidth(1400)
            ->minHeight(800)
            ->showDevTools(false)
            ->rememberState();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }

    /**
     * Determine if the database needs to be seeded.
     */
    protected function shouldSeedDatabase(): bool
    {
        // Check if the users table exists and is empty
        return Schema::hasTable('users') && DB::table('users')->count() === 0;
    }

    /**
     * Run the database migrations if needed.
     */
    protected function runMigrations(): void
    {
        // Check if migrations have been run, if not, run them
        if (Artisan::call('migrate:status') !== 0) {
            Artisan::call('migrate', ['--force' => true]);
        }
    }

    /**
     * Run the database seeder.
     */
    protected function runDatabaseSeeding(): void
    {
        Artisan::call('db:seed', ['--force' => true]);
    }
}
