<?php

namespace App\Providers;

use Fruitcake\TelescopeToolbar\ToolbarServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        if ($this->app->environment('local')) {
            if (class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
                $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
                $this->app->register(TelescopeServiceProvider::class);
            }

            if (class_exists(ToolbarServiceProvider::class)) {
                $this->app->register(ToolbarServiceProvider::class);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        EnsureFeaturesAreActive::whenInactive(
            fn () => abort(Response::HTTP_NOT_FOUND),
        );
    }
}
