<?php

namespace App\Providers;

use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\User;
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
        Gate::define('access-admin', fn (User $user): bool => $user->is_admin);

        View::composer('layouts.public', function ($view): void {
            $view->with('business', BusinessSetting::first());
            $view->with('footerCategories', Category::orderBy('name')->get(['name', 'slug']));
        });
    }
}
