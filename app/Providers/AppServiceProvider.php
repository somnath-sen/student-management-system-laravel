<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notice;
use App\Models\StudentRegistration;
use App\Models\FacultyRegistration;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Inject $latestNotices into student layout
        View::composer('layouts.student', function ($view) {
            $latestNotices = Notice::latest()->take(5)->get();
            $view->with('latestNotices', $latestNotices);
        });

        // Inject pending registration counts into admin layout (for sidebar badges)
        View::composer('layouts.admin', function ($view) {
            $view->with([
                'pendingStudentRegistrations' => StudentRegistration::where('status', 'pending')->count(),
                'pendingFacultyRegistrations' => FacultyRegistration::where('status', 'pending')->count(),
            ]);
        });
    }
}