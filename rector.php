<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/app-modules/*/src',
        __DIR__.'/modules/*/src',
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_85,
        LaravelLevelSetList::UP_TO_LARAVEL_120,
    ]);
