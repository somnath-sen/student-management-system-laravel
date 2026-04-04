<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EdFlow') }}</title>

        <!-- Tailwind CDN (used by other pages) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- AlpineJS (used by some components) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Vite assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            html, body { margin: 0; padding: 0; height: 100%; width: 100%; }
        </style>
    </head>
    <body style="margin:0;padding:0;min-height:100vh;">
        {{ $slot }}
    </body>
</html>
