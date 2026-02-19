<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Developer;
use App\Policies\ArticlePolicy;
use App\Policies\DeveloperPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Developer::class, DeveloperPolicy::class);
    }
}
