<?php

declare(strict_types=1);

namespace App\Enums;

use Empire\Hello\Modules\HelloModule;
use Empire\Ping\Modules\PingModule;
use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Feature;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

enum Module: string
{
    case Hello = HelloModule::class;
    case Ping = PingModule::class;

    public static function defineFeatures(): void
    {
        foreach (self::cases() as $module) {
            Feature::define($module->value, true);
        }
    }

    public static function loadWebRoutes(): void
    {
        foreach (self::web() as $module) {
            $webRoute = $module::webRoute();
            assert(is_string($webRoute));

            Route::middleware([
                EnsureFeaturesAreActive::using($module),
                'web',
            ])->group($webRoute);
        }
    }

    public static function loadApiRoutes(): void
    {
        foreach (self::api() as $module) {
            $apiRoute = $module::apiRoute();
            assert(is_string($apiRoute));

            Route::middleware([
                EnsureFeaturesAreActive::using($module),
                'api',
            ])->prefix('api')->group($apiRoute);
        }
    }

    public static function loadConsoleRoutes(): void
    {
        foreach (self::console() as $module) {
            require $module::consoleRoute();
        }
    }

    /** @return class-string[] */
    private static function web(): array
    {
        return self::modulesDefining('webRoute');
    }

    /** @return class-string[] */
    private static function api(): array
    {
        return self::modulesDefining('apiRoute');
    }

    /** @return class-string[] */
    private static function console(): array
    {
        return self::modulesDefining('consoleRoute');
    }

    /** @return class-string[] */
    private static function modulesDefining(string $method): array
    {
        return array_filter(
            array_map(fn (self $module) => $module->value, self::cases()),
            fn (string $class) => is_callable([$class, $method]),
        );
    }
}
