<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notice; // Add this line

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // This injects $latestNotices into ANY view that extends layouts.student
        View::composer('layouts.student', function ($view) {
            $latestNotices = Notice::latest()->take(5)->get();
            $view->with('latestNotices', $latestNotices);
        });
    }
}