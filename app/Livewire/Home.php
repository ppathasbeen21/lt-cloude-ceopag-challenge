<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $userId = Auth::id();

        $devCount       = Developer::where('user_id', $userId)->count();
        $articleCount   = Article::where('user_id', $userId)->count();
        $publishedCount = Article::where('user_id', $userId)->whereNotNull('published_at')->count();
        $draftCount     = Article::where('user_id', $userId)->whereNull('published_at')->count();

        $articles = Article::with(['developers', 'category'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $developers = Developer::withCount(['articles' => function ($q) use ($userId) {
            $q->where('articles.user_id', $userId);
        }])
            ->where('user_id', $userId)
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return view('livewire.home', compact(
            'devCount',
            'articleCount',
            'publishedCount',
            'draftCount',
            'articles',
            'developers'
        ))->layout('layouts.livewire');
    }
}
