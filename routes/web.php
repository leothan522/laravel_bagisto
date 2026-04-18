<?php
use Illuminate\Support\Facades\Route;

Route::get('/instalar-app', function () {
    return view('install-app');
})->name('pwa.install');
