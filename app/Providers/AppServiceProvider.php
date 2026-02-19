<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Developer;
use App\Policies\ArticlePolicy;
use App\Policies\DeveloperPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
        \Livewire\Livewire::addPersistentMiddleware([
            \Illuminate\Session\Middleware\StartSession::class,
        ]);
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Developer::class, DeveloperPolicy::class);
    }
}
