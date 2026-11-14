@extends('layouts.auth')

@section('title', 'Log in')
@section('heading', 'Log in')

@section('content')
    @php($loginField = \App\Models\User::loginField())

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        @if ($loginField === 'username')
            <x-input
                id="username"
                name="username"
                type="text"
                label="Username"
                :value="old('username')"
                required
                autofocus
                autocomplete="username"
            />
        @else
            <x-input
                id="email"
                name="email"
                type="email"
                label="Email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
        @endif

        <x-password
            id="password"
            name="password"
            label="Password"
            required
            autocomplete="current-password"
        />

        <div class="pt-2">
            <x-button type="submit" text="Log in" class="w-full" />
        </div>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600 dark:text-dark-300">
        <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
            Create an account
        </a>
    </p>
@endsection
