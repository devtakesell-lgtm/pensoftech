<?php

namespace App\Providers;

use App\Enums\LeadStatus;
use App\Models\Currency;
use App\Models\Lead;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        Blade::anonymousComponentPath(resource_path('views'));

        // Grant all permissions to administrator / super-admin role
        Gate::before(function ($user, string $ability) {
            return $user->hasRole('administrator') ? true : null;
        });

        // Automatically provide global agency data and counts to all admin views
        View::composer('admin.*', function ($view) {
            if (! $view->offsetExists('defaultCurrency')) {
                $view->with('defaultCurrency', rescue(fn () => Currency::default(), null, report: false));
            }

            if (! $view->offsetExists('newLeadsCount')) {
                $view->with('newLeadsCount', rescue(fn () => Lead::where('status', LeadStatus::New)->count(), 0, report: false));
            }
        });
    }
}
