<?php

namespace App\Providers;

use Native\Laravel\Facades\Menu;
use Illuminate\Support\Facades\DB;
use Native\Laravel\Facades\Window;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Native\Laravel\Contracts\ProvidesPhpIni;

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

        Menu::create(
            Menu::app(),
            Menu::edit(),
            Menu::view(),
            Menu::make(
                Menu::link('https://docs.flightadmin.info', 'Documentation'),
                Menu::separator(),
                Menu::link('https://docs.flightadmin.info', 'Sign Out'),
            )->label('Help'),
            Menu::window(),
        );

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

    protected function shouldSeedDatabase(): bool
    {
        return Schema::hasTable('users') && DB::table('users')->count() === 0;
    }

    protected function runMigrations(): void
    {
        if (Artisan::call('migrate:status') !== 0) {
            Artisan::call('migrate', ['--force' => true]);
        }
    }

    protected function runDatabaseSeeding(): void
    {
        Artisan::call('db:seed', ['--force' => true]);
    }
}
