<?php

namespace App\Providers;

use Native\Laravel\Menu\Menu;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Menu::new()
            ->fileMenu()
            ->windowMenu()
            ->viewMenu()
            ->editMenu()
            ->submenu(
                'Help',
                Menu::new()
                    ->link('https://github.com/georgechitechi/loadcontrol', 'Documentation')
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
            // ->showDevTools(false)
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
}
