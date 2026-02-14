<?php

use App\Livewire\Developer\Form as DeveloperForm;
use App\Livewire\Developer\Index as DeveloperIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/developers', DeveloperIndex::class)->name('developers.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/developers', DeveloperIndex::class)->name('developers.index');
    Route::get('/developers/create', DeveloperForm::class)->name('developers.create');
    Route::get('/developers/{developerId}/edit', DeveloperForm::class)->name('developers.edit');
});
