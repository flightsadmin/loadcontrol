<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        view()->composer('*', function ($view) {
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
