@extends('layouts.auth')

@section('title', 'Register')
@section('heading', 'Create an account')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf

        <x-input
            id="name"
            name="name"
            type="text"
            label="Name"
            class="px-3"
            :value="old('name')"
            required
            autofocus
            autocomplete="name"
        />

        <x-input
            id="username"
            name="username"
            type="text"
            label="Username"
            class="px-3"
            :value="old('username')"
            required
            autocomplete="username"
        />

        <x-input
            id="email"
            name="email"
            type="email"
            label="Email"
            class="px-3"
            :value="old('email')"
            required
            autocomplete="email"
        />

        <x-password
            id="password"
            name="password"
            label="Password"
            required
            autocomplete="new-password"
        />

        <x-password
            id="password_confirmation"
            name="password_confirmation"
            label="Confirm password"
            required
            autocomplete="new-password"
        />

        <div class="pt-2">
            <x-button type="submit" text="Register" class="w-full" />
        </div>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600 dark:text-dark-300">
        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
            Already registered? Log in
        </a>
    </p>
@endsection
