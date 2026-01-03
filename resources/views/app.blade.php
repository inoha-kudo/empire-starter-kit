<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @viteReactRefresh
        @if(str_contains($page['component'], '::'))
            @php
                [$module, $path] = explode('::', $page['component']);
            @endphp
            @vite(['resources/js/app.tsx', "vendor/empire/{$module}/resources/js/pages/{$path}.tsx", 'webfonts.css'])
        @else
            @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx", 'webfonts.css'])
        @endif
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
