<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full scroll-smooth"
    x-data="tallstackui_darkTheme()"
    x-bind:class="{ 'dark': darkTheme }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Basic TALL') }} — TALL Stack Starter &amp; TallStackUI Showcase</title>

        @fonts

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-gray-50 font-sans text-gray-900 antialiased dark:bg-dark-900 dark:text-dark-50">
        <x-dialog />
        <x-toast />

        {{-- Top Navigation --}}
        <header class="sticky top-0 z-30 border-b border-gray-200/80 bg-white/85 backdrop-blur-md dark:border-dark-700/80 dark:bg-dark-900/85">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-600 text-white shadow-sm">
                        <x-icon name="cube-transparent" class="h-5 w-5" />
                    </span>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ config('app.name', 'Basic TALL') }}
                        </span>
                        <span class="text-[11px] font-medium text-gray-500 dark:text-dark-400">
                            Laravel 13 · Livewire 4 · TallStackUI v4
                        </span>
                    </div>
                </a>

                <nav class="hidden items-center gap-6 text-sm font-medium text-gray-600 md:flex dark:text-dark-300">
                    <a href="#overview" class="transition hover:text-primary-600 dark:hover:text-primary-400">Overview</a>
                    <a href="#architecture" class="transition hover:text-primary-600 dark:hover:text-primary-400">Architecture</a>
                    <a href="#components" class="transition hover:text-primary-600 dark:hover:text-primary-400">Components</a>
                </nav>

                <div class="flex items-center gap-2.5">
                    <x-theme-switch simple only-icons />

                    @if (Route::has('login'))
                        @auth
                            <x-button :href="url('/dashboard')" text="Dashboard" icon="squares-2x2" sm />
                        @else
                            <x-button :href="route('login')" text="Log in" color="secondary" outline sm />
                            @if (Route::has('register'))
                                <x-button :href="route('register')" text="Register" sm />
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main>
            {{-- Hero Section --}}
            <section id="overview" class="relative overflow-hidden border-b border-gray-200/70 bg-white dark:border-dark-800 dark:bg-dark-900">
                <div class="pointer-events-none absolute inset-x-0 -top-40 -z-0 flex justify-center overflow-hidden blur-3xl" aria-hidden="true">
                    <div class="h-72 w-[48rem] rounded-full bg-gradient-to-tr from-primary-500/20 via-sky-400/15 to-emerald-400/20 dark:from-primary-500/15 dark:via-sky-500/10 dark:to-emerald-500/10"></div>
                </div>

                <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                    <div class="grid items-center gap-12 lg:grid-cols-12">
                        <div class="flex flex-col items-start gap-6 lg:col-span-7">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-badge text="TALL Stack Starter" color="primary" light round icon="sparkles" />
                                <x-badge text="Laravel v{{ Illuminate\Foundation\Application::VERSION }}" color="secondary" outline round />
                                <x-badge text="Tailwind CSS v4" color="sky" light round />
                            </div>

                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl dark:text-white">
                                Build modular Laravel apps fast with
                                <span class="text-primary-600 dark:text-primary-400">TallStackUI</span>.
                            </h1>

                            <p class="max-w-2xl text-base leading-relaxed text-gray-600 sm:text-lg dark:text-dark-300">
                                <strong>{{ config('app.name', 'Basic TALL') }}</strong> is a clean, production-minded starter kit combining
                                Laravel 13, Livewire 4, Tailwind CSS v4, TallStackUI v4, and Spatie Laravel Permission
                                inside a modular <code class="rounded bg-gray-100 px-1.5 py-0.5 text-sm font-mono text-gray-800 dark:bg-dark-800 dark:text-dark-100">app/Modules</code> structure.
                            </p>

                            <div class="flex flex-wrap items-center gap-3 pt-1">
                                <x-button href="#components" text="Explore Components" icon="squares-plus" lg />
                                @if (Route::has('register'))
                                    @auth
                                        <x-button :href="url('/dashboard')" text="Open Dashboard" color="secondary" outline lg icon="arrow-right" position="right" />
                                    @else
                                        <x-button :href="route('register')" text="Create Account" color="secondary" outline lg icon="user-plus" />
                                    @endauth
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center gap-6 pt-2 text-sm text-gray-500 dark:text-dark-400">
                                <div class="flex items-center gap-2">
                                    <x-icon name="check-circle" class="h-4 w-4 text-emerald-500" />
                                    <span>Auth &amp; Dashboard Modules</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-icon name="check-circle" class="h-4 w-4 text-emerald-500" />
                                    <span>Dark Mode Ready</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-icon name="check-circle" class="h-4 w-4 text-emerald-500" />
                                    <span>50+ TallStackUI Components</span>
                                </div>
                            </div>
                        </div>

                        {{-- Hero Interactive Preview Card --}}
                        <div class="lg:col-span-5">
                            <x-card header="Quick Start &amp; Live Preview">
                                <div class="flex flex-col gap-4">
                                    <x-alert color="primary" icon="information-circle" light>
                                        Everything on this page is rendered with native TallStackUI v4 Blade components and Alpine.js helpers.
                                    </x-alert>

                                    <x-clipboard
                                        label="Start the local dev environment"
                                        text="composer run dev"
                                        hint="Runs Laravel server, queue listener, Pail logs, and Vite."
                                    />

                                    <div class="grid grid-cols-2 gap-3">
                                        <x-button
                                            text="Trigger Toast"
                                            icon="bell-alert"
                                            color="emerald"
                                            light
                                            x-on:click="$tsui.interaction('toast').success('Toast Ready!', 'TallStackUI toast notifications work out of the box.').send()"
                                        />
                                        <x-button
                                            text="Open Modal"
                                            icon="window"
                                            color="primary"
                                            outline
                                            x-on:click="$tsui.open.modal('demo-modal')"
                                        />
                                    </div>
                                </div>

                                <x-slot:footer>
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-dark-400">
                                        <span>PHP v{{ PHP_VERSION }}</span>
                                        <span>Try toggling the theme switch above</span>
                                    </div>
                                </x-slot:footer>
                            </x-card>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Project Architecture Section --}}
            <section id="architecture" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-2">
                    <x-badge text="Project Architecture" color="primary" light class="w-fit" />
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl dark:text-white">
                        What’s inside {{ config('app.name', 'Basic TALL') }}
                    </h2>
                    <p class="max-w-2xl text-sm text-gray-600 sm:text-base dark:text-dark-300">
                        Organized for clarity and scale, with batteries included for authentication, role permissions, and reactive UI.
                    </p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <x-card>
                        <div class="flex flex-col gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/50 dark:text-red-400">
                                <x-icon name="folder-open" class="h-5 w-5" />
                            </span>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Modular Structure</h3>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                                Feature modules live under <code class="text-xs font-mono">app/Modules/</code> with dedicated routes, views, controllers, and services.
                            </p>
                        </div>
                    </x-card>

                    <x-card>
                        <div class="flex flex-col gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-950/50 dark:text-primary-400">
                                <x-icon name="bolt" class="h-5 w-5" />
                            </span>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Livewire 4 + Alpine</h3>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                                Server-driven reactivity with zero build friction and seamless client-side interactivity via Alpine.js.
                            </p>
                        </div>
                    </x-card>

                    <x-card>
                        <div class="flex flex-col gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-50 text-sky-600 dark:bg-sky-950/50 dark:text-sky-400">
                                <x-icon name="swatch" class="h-5 w-5" />
                            </span>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">TallStackUI v4</h3>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                                Styled with Tailwind CSS v4, featuring consistent dark mode tokens, form controls, modals, toasts, and data components.
                            </p>
                        </div>
                    </x-card>

                    <x-card>
                        <div class="flex flex-col gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                                <x-icon name="shield-check" class="h-5 w-5" />
                            </span>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Auth &amp; Permissions</h3>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                                Pre-built <code class="text-xs font-mono">Auth</code> &amp; <code class="text-xs font-mono">Dashboard</code> modules paired with Spatie Laravel Permission.
                            </p>
                        </div>
                    </x-card>
                </div>
            </section>

            {{-- TallStackUI Components Showcase --}}
            <section id="components" class="border-t border-gray-200/70 bg-white/60 py-16 dark:border-dark-800 dark:bg-dark-900/40">
                <div class="mx-auto flex max-w-7xl flex-col gap-12 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col gap-2">
                        <x-badge text="Component Showcase" color="emerald" light class="w-fit" />
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl dark:text-white">
                            Commonly Used TallStackUI Components
                        </h2>
                        <p class="max-w-2xl text-sm text-gray-600 sm:text-base dark:text-dark-300">
                            A live, interactive gallery of the everyday TallStackUI components ready to use across your Blade views and Livewire components.
                        </p>
                    </div>

                    {{-- 1. Stats KPI Cards --}}
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Stats &amp; KPIs</h3>
                            <code class="rounded bg-gray-100 px-2 py-1 text-xs font-mono text-gray-700 dark:bg-dark-800 dark:text-dark-200">&lt;x-stats /&gt;</code>
                        </div>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <x-stats
                                title="Active Modules"
                                :number="12"
                                icon="cube"
                                color="primary"
                                increase
                                animated
                            />
                            <x-stats
                                title="UI Components"
                                :number="50"
                                icon="squares-2x2"
                                color="emerald"
                                increase
                                animated
                            />
                            <x-stats
                                title="Build Overhead"
                                :number="0"
                                icon="bolt"
                                color="amber"
                                light
                            />
                        </div>
                    </div>

                    {{-- 2. Buttons, Badges & Alerts --}}
                    <div class="grid gap-6 lg:grid-cols-2">
                        <x-card header="Buttons &amp; Badges">
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-dark-400">Button Variants</span>
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <x-button text="Primary" />
                                        <x-button text="Secondary" color="secondary" />
                                        <x-button text="Success" color="emerald" icon="check" />
                                        <x-button text="Outline" color="primary" outline />
                                        <x-button text="Light" color="sky" light />
                                        <x-button text="Danger" color="red" outline icon="trash" />
                                        <x-button.circle icon="plus" color="primary" />
                                        <x-button.circle icon="heart" color="rose" light />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2.5">
                                    <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-dark-400">Badges</span>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <x-badge text="Default" />
                                        <x-badge text="Published" color="emerald" icon="check-circle" round />
                                        <x-badge text="In Review" color="amber" light round />
                                        <x-badge text="Beta" color="indigo" outline />
                                        <x-badge text="Deprecated" color="red" light />
                                    </div>
                                </div>
                            </div>
                        </x-card>

                        <x-card header="Alerts">
                            <div class="flex flex-col gap-3">
                                <x-alert title="Deployment Complete" color="emerald" icon="check-circle" light>
                                    Your application assets and migrations are up to date.
                                </x-alert>
                                <x-alert color="sky" icon="information-circle" close>
                                    Dismissible info alert — click the close icon to hide it.
                                </x-alert>
                                <x-alert color="amber" icon="exclamation-triangle" outline>
                                    Heads up: configure your mail driver before enabling verification emails.
                                </x-alert>
                            </div>
                        </x-card>
                    </div>

                    {{-- 3. Form Inputs & Controls --}}
                    <x-card header="Form Controls">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="flex flex-col gap-4">
                                <x-input
                                    label="Project Name"
                                    placeholder="basic-tall"
                                    icon="folder"
                                    hint="Used in your application header and page titles."
                                />

                                <x-password
                                    label="API Secret"
                                    placeholder="Enter a strong secret"
                                    hint="Click the eye icon to toggle visibility."
                                />

                                <x-select.styled
                                    label="Primary Stack Focus"
                                    placeholder="Select a layer..."
                                    :options="[
                                        ['label' => 'Laravel 13 Backend', 'value' => 'laravel'],
                                        ['label' => 'Livewire 4 Components', 'value' => 'livewire'],
                                        ['label' => 'TallStackUI v4 Kit', 'value' => 'tallstackui'],
                                        ['label' => 'Tailwind CSS v4', 'value' => 'tailwind'],
                                    ]"
                                    select="label:label|value:value"
                                    searchable
                                />

                                <x-number
                                    label="Worker Concurrency"
                                    :min="1"
                                    :max="16"
                                    value="4"
                                    hint="Number of parallel queue workers."
                                />
                            </div>

                            <div class="flex flex-col gap-4">
                                <x-textarea
                                    label="Release Notes"
                                    placeholder="Summarize what changed in this release..."
                                    rows="4"
                                />

                                <div class="flex flex-col gap-3 rounded-lg border border-gray-200 p-4 dark:border-dark-700">
                                    <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-dark-400">Selection Controls</span>
                                    <x-toggle label="Enable dark mode by default" checked />
                                    <x-checkbox label="Send weekly digest notifications" checked />
                                    <div class="flex flex-wrap items-center gap-4 pt-1">
                                        <x-radio name="visibility" label="Public" value="public" checked />
                                        <x-radio name="visibility" label="Team Only" value="team" />
                                        <x-radio name="visibility" label="Private" value="private" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>

                    {{-- 4. Overlays, Dropdowns & Interactive Triggers --}}
                    <x-card header="Overlays, Dropdowns &amp; Interactions">
                        <div class="flex flex-wrap items-center gap-3">
                            <x-button
                                text="Open Modal"
                                icon="window"
                                x-on:click="$tsui.open.modal('demo-modal')"
                            />
                            <x-button
                                text="Open Slide-over"
                                icon="bars-3-bottom-right"
                                color="indigo"
                                x-on:click="$tsui.open.slide('demo-slide')"
                            />
                            <x-button
                                text="Show Toast"
                                icon="bell"
                                color="emerald"
                                light
                                x-on:click="$tsui.interaction('toast').success('Saved!', 'Your changes were saved successfully.').send()"
                            />
                            <x-button
                                text="Show Dialog"
                                icon="chat-bubble-left-right"
                                color="amber"
                                light
                                x-on:click="$tsui.interaction('dialog').info('TallStackUI Dialog', 'Dialogs support info, success, warning, error, and confirmation actions.').send()"
                            />

                            <x-dropdown text="Actions" icon="chevron-down" position="bottom-start">
                                <x-dropdown.items text="View Dashboard" icon="home" :href="Route::has('dashboard') ? route('dashboard') : '#'" />
                                <x-dropdown.items text="Trigger Toast" icon="sparkles" x-on:click="$tsui.interaction('toast').info('Hello!', 'Triggered from a dropdown item.').send()" />
                                <x-dropdown.items text="Open Modal" icon="window" separator x-on:click="$tsui.open.modal('demo-modal')" />
                            </x-dropdown>

                            <x-tooltip text="Built with TallStackUI Tooltip!" color="dark" position="top" />
                        </div>
                    </x-card>

                    {{-- 5. Tabs, Accordions, Avatars, Progress & Timeline --}}
                    <div class="grid gap-6 lg:grid-cols-2">
                        <x-tab selected="Overview">
                            <x-tab.items tab="Overview">
                                <div class="flex flex-col gap-4 py-2">
                                    <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                                        Tabs, progress indicators, and avatar groups work together cleanly for dashboards, user profiles, and onboarding flows.
                                    </p>

                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <x-avatar.group>
                                                <x-avatar text="AL" color="primary" borderless />
                                                <x-avatar text="MK" color="emerald" borderless />
                                                <x-avatar text="JR" color="amber" borderless />
                                                <x-avatar text="+4" color="secondary" borderless />
                                            </x-avatar.group>
                                            <span class="text-xs text-gray-500 dark:text-dark-400">Active contributors</span>
                                        </div>
                                        <x-progress.circle :percent="78" color="primary" sm />
                                    </div>

                                    <x-progress :percent="78" title="Setup Completion" color="emerald" />
                                </div>
                            </x-tab.items>

                            <x-tab.items tab="Blade Usage">
                                <div class="py-2">
                                    <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100 dark:bg-dark-950"><code>&lt;x-card header="Account"&gt;
    &lt;x-input label="Email" name="email" /&gt;
    &lt;x-button text="Save" color="primary" /&gt;
&lt;/x-card&gt;</code></pre>
                                </div>
                            </x-tab.items>

                            <x-tab.items tab="Included">
                                <ul class="flex flex-col gap-2 py-2 text-sm text-gray-600 dark:text-dark-300">
                                    <li class="flex items-center gap-2">
                                        <x-icon name="check" class="h-4 w-4 text-emerald-500" />
                                        <span>Automatic dark mode via <code class="text-xs font-mono">tallstackui_darkTheme()</code></span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <x-icon name="check" class="h-4 w-4 text-emerald-500" />
                                        <span>Tailwind CSS v4 theme tokens &amp; Vite bundling</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <x-icon name="check" class="h-4 w-4 text-emerald-500" />
                                        <span>Zero custom JS required for modals, slides, or toasts</span>
                                    </li>
                                </ul>
                            </x-tab.items>
                        </x-tab>

                        <x-accordion>
                            <x-accordion.items title="How are modules organized?" open>
                                Modules live in <code class="text-xs font-mono">app/Modules/</code> (such as <code class="text-xs font-mono">Auth</code> and <code class="text-xs font-mono">Dashboard</code>), keeping routes, controllers, requests, services, and views grouped by domain.
                            </x-accordion.items>
                            <x-accordion.items title="Do TallStackUI components require Livewire?">
                                Form bindings like <code class="text-xs font-mono">wire:model</code> integrate directly with Livewire 4, while display, layout, and Alpine-powered interactive components also work in standard Blade views.
                            </x-accordion.items>
                            <x-accordion.items title="How do I customize component styles?">
                                TallStackUI v4 supports soft customization in a service provider as well as Tailwind CSS v4 theme variables in <code class="text-xs font-mono">resources/css/app.css</code>.
                            </x-accordion.items>
                        </x-accordion>
                    </div>

                    {{-- 6. Timeline --}}
                    <x-card header="Typical Workflow Timeline">
                        <x-timeline>
                            <x-timeline.items
                                title="1. Scaffold Module"
                                description="Create a module folder under app/Modules with routes, views, and services."
                                date="Step 1"
                                icon="folder-plus"
                                color="primary"
                            />
                            <x-timeline.items
                                title="2. Compose UI with TallStackUI"
                                description="Build forms, cards, tables, modals, and feedback alerts using Blade components."
                                date="Step 2"
                                icon="squares-2x2"
                                color="sky"
                            />
                            <x-timeline.items
                                title="3. Verify with PHPUnit &amp; Pint"
                                description="Run feature tests and format code with Laravel Pint before shipping."
                                date="Step 3"
                                icon="check-badge"
                                color="emerald"
                            />
                        </x-timeline>
                    </x-card>
                </div>
            </section>
        </main>

        {{-- Demo Modal --}}
        <x-modal id="demo-modal" title="TallStackUI Modal" center>
            <p class="text-sm leading-relaxed text-gray-600 dark:text-dark-300">
                This modal is powered by <code class="text-xs font-mono">&lt;x-modal&gt;</code> and opened via
                <code class="text-xs font-mono">$tsui.open.modal('demo-modal')</code>. It supports blur backdrops,
                sizes, scrollable content, and Livewire entanglement.
            </p>
            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-button text="Close" color="secondary" outline x-on:click="$tsui.close.modal('demo-modal')" />
                    <x-button
                        text="Confirm &amp; Toast"
                        x-on:click="$tsui.close.modal('demo-modal'); $tsui.interaction('toast').success('Confirmed!', 'Modal action completed.').send()"
                    />
                </div>
            </x-slot:footer>
        </x-modal>

        {{-- Demo Slide-over --}}
        <x-slide id="demo-slide" title="Quick Settings Slide-over">
            <div class="flex flex-col gap-4">
                <p class="text-sm text-gray-600 dark:text-dark-300">
                    Slide-overs are ideal for filters, detail drawers, and quick configuration panels.
                </p>
                <x-input label="Workspace Name" value="{{ config('app.name', 'Basic TALL') }}" />
                <x-toggle label="Enable live notifications" checked />
                <x-toggle label="Compact sidebar layout" />
            </div>
            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-button text="Cancel" color="secondary" outline x-on:click="$tsui.close.slide('demo-slide')" />
                    <x-button
                        text="Save Settings"
                        x-on:click="$tsui.close.slide('demo-slide'); $tsui.interaction('toast').success('Settings Saved', 'Slide-over preferences updated.').send()"
                    />
                </div>
            </x-slot:footer>
        </x-slide>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 bg-white py-8 dark:border-dark-800 dark:bg-dark-900">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 text-sm text-gray-500 sm:flex-row sm:px-6 lg:px-8 dark:text-dark-400">
                <p>
                    <span class="font-semibold text-gray-800 dark:text-dark-100">{{ config('app.name', 'Basic TALL') }}</span>
                    — Laravel v{{ Illuminate\Foundation\Application::VERSION }} · PHP v{{ PHP_VERSION }}
                </p>
                <div class="flex items-center gap-5">
                    <a href="https://laravel.com/docs" target="_blank" rel="noopener" class="hover:text-primary-600 dark:hover:text-primary-400">Laravel Docs</a>
                    <a href="https://livewire.laravel.com" target="_blank" rel="noopener" class="hover:text-primary-600 dark:hover:text-primary-400">Livewire</a>
                    <a href="https://tallstackui.com" target="_blank" rel="noopener" class="hover:text-primary-600 dark:hover:text-primary-400">TallStackUI</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
