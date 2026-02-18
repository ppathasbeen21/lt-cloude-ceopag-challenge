<?php

use App\Livewire\Article\Form as ArticleForm;
use App\Livewire\Article\Index as ArticleIndex;
use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Developer\Form as DeveloperForm;
use App\Livewire\Developer\Index as DeveloperIndex;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', Home::class)->name('home');
    Route::get('/articles',                   ArticleIndex::class)->name('articles.index');
    Route::get('/articles/create',            ArticleForm::class)->name('articles.create');
    Route::get('/articles/{articleId}/edit',  ArticleForm::class)->name('articles.edit');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/developers',                    DeveloperIndex::class)->name('developers.index');
    Route::get('/developers/create',             DeveloperForm::class)->name('developers.create');
    Route::get('/developers/{developerId}/edit', DeveloperForm::class)->name('developers.edit');

});
