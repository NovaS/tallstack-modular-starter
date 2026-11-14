<?php

use Illuminate\Support\Facades\Route;

Route::view('/dashboard', 'dashboard::index')
    ->middleware('auth')
    ->name('dashboard');
