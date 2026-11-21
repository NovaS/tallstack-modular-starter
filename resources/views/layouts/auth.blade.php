<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
    x-data="tallstackui_darkTheme({ default: 'light' })"
    x-bind:class="{ 'dark': darkTheme }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} — @yield('title', 'Authentication')</title>

    @include('layouts.partials.theme-init')

    @fonts

    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center bg-slate-100 py-12 font-sans text-slate-900 antialiased sm:px-6 lg:px-8 dark:bg-dark-900 dark:text-dark-50">
    <x-dialog />
    <x-toast />

    <main class="mx-auto w-full max-w-md px-4 sm:px-0">
        <x-card>
            <x-slot:header>
                <h1 class="text-xl font-semibold text-slate-900 dark:text-white">@yield('heading')</h1>
                <div class="flex min-h-5 min-w-8 items-center justify-center">
                    <x-theme-switch simple sm />
                </div>
            </x-slot:header>

            @yield('content')
            {{ $slot ?? '' }}
        </x-card>
    </main>

    @livewireScripts
</body>
</html>
