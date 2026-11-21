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
    <title>{{ config('app.name', 'Laravel') }}@hasSection('title') — @yield('title')@endif</title>

    @include('layouts.partials.theme-init')

    @fonts

    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-50 font-sans text-slate-900 antialiased dark:bg-dark-900 dark:text-dark-50">
    <x-dialog />
    <x-toast />

    <x-layout>
        <x-slot:header>
            <x-layout.header>
                <x-slot:left>
                    <span class="text-base font-semibold text-slate-900 dark:text-white">
                        @yield('heading', config('app.name', 'Laravel'))
                    </span>
                </x-slot:left>
                <x-slot:right>
                    <div class="flex items-center gap-3">
                        <div class="flex min-h-5 min-w-8 items-center justify-center">
                            <x-theme-switch simple sm />
                        </div>
                        @auth
                            <span class="text-sm text-slate-600 dark:text-dark-300">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button
                                    type="submit"
                                    text="Log out"
                                    color="slate"
                                    sm
                                    outline
                                    class="dark:text-slate-200 dark:border-slate-500 dark:hover:bg-slate-700/60 dark:hover:text-white"
                                />
                            </form>
                        @endauth
                    </div>
                </x-slot:right>
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
