<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} — @yield('title', 'Authentication')</title>

    @fonts

    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center bg-gray-100 py-12 font-sans text-gray-900 antialiased sm:px-6 lg:px-8 dark:bg-dark-900 dark:text-dark-50">
    <x-dialog />
    <x-toast />

    <main class="mx-auto w-full max-w-md px-4 sm:px-0">
        <x-card>
            <x-slot:header>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">@yield('heading')</h1>
            </x-slot:header>

            @yield('content')
            {{ $slot ?? '' }}
        </x-card>
    </main>

    @livewireScripts
</body>
</html>
