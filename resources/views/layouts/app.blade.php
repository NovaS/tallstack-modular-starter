<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}@hasSection('title') — @yield('title')@endif</title>

    @fonts

    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-gray-50 font-sans text-gray-900 antialiased dark:bg-dark-900 dark:text-dark-50">
    <x-dialog />
    <x-toast />

    <x-layout>
        <x-slot:header>
            <x-layout.header>
                <x-slot:left>
                    <span class="text-base font-semibold text-gray-900 dark:text-white">
                        @yield('heading', config('app.name', 'Laravel'))
                    </span>
                </x-slot:left>
                @auth
                    <x-slot:right>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600 dark:text-dark-300">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button type="submit" text="Log out" color="secondary" sm outline />
                            </form>
                        </div>
                    </x-slot:right>
                @endauth
            </x-layout.header>
        </x-slot:header>

        <x-slot:menu>
            <x-side-bar smart navigate>
                <x-slot:brand>
                    <div class="flex items-center px-4 py-5">
                        <span class="text-lg font-bold tracking-tight text-primary-600 dark:text-primary-400">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </div>
                </x-slot:brand>
                <x-side-bar.item text="Dashboard" :route="route('dashboard')" icon="home" />
            </x-side-bar>
        </x-slot:menu>

        @yield('content')
        {{ $slot ?? '' }}
    </x-layout>

    @livewireScripts
</body>
</html>
