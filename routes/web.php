<?php

use App\Filament\Pages\BlogPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

