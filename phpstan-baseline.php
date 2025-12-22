<?php

declare(strict_types=1);

$paths = [
    ...(glob(__DIR__.'/app-modules/*/src', GLOB_ONLYDIR) ?: []),
    ...(glob(__DIR__.'/modules/*/src', GLOB_ONLYDIR) ?: []),
];

sort($paths, SORT_NATURAL);

return [
    'parameters' => [
        'paths' => $paths,
    ],
];
