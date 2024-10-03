<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            if ($date = request()->input('date')) {
                session(['selectedDate' => $date]);
            }
            $selectedDate = session('selectedDate');
            $query = \App\Models\Flight::query();
            if ($selectedDate) {
                $query->whereDate('departure', $selectedDate);
            }
            $view->with('flights', $query->orderBy('departure')->simplePaginate());
        });
    }
}
