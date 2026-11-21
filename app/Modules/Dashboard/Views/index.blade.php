@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Welcome, '.auth()->user()->name)

@section('content')
    <x-card header="Account Overview">
        <p class="text-sm text-slate-600 dark:text-dark-300">
            You are signed in as <span class="font-medium text-slate-900 dark:text-white">{{ auth()->user()->email }}</span>.
        </p>
    </x-card>
@endsection
