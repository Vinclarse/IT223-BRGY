<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\AppointmentComposer;

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
        // Share appointment data with all resident pages
        view()->composer([
            // Dashboard
            'resident_dashboard',
            // E-Serbisyo pages
            'e-serbisyo',
            'requestDocument',
            'my-requests',
            'my-complaints',
            // Other resident pages
            'transparency',
            'community',
            'disasterPreparedness',
            'about',
            // Profile pages
            'profile',
            'profile.edit',
            // Appointments page
            'resident_appointments',
        ], AppointmentComposer::class);
    }
}