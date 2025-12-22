<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Facades\Route;

enum Module: string
{
    public static function loadWebRoutes(): void
    {
        foreach (self::web() as $module) {
            $webRoute = $module::webRoute();
            assert(is_string($webRoute));

            Route::middleware('web')->group($webRoute);
        }
    }

    public static function loadApiRoutes(): void
    {
        foreach (self::api() as $module) {
            $apiRoute = $module::apiRoute();
            assert(is_string($apiRoute));

            Route::middleware('api')->prefix('api')->group($apiRoute);
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
