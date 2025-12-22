<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Module;
use Illuminate\Support\ServiceProvider;

final class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadWebRoutes();
        $this->loadApiRoutes();
        $this->loadConsoleRoutes();
    }

    private function loadWebRoutes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Module::loadWebRoutes();
    }

    private function loadApiRoutes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Module::loadApiRoutes();
    }

    private function loadConsoleRoutes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        Module::loadConsoleRoutes();
    }
}
