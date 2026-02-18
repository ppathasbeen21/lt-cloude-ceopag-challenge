<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $articles = Article::with(['developers', 'category'])
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(6)
            ->get();

        $developers = Developer::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return view('livewire.home', compact('articles', 'developers'))
            ->layout('layouts.app');
    }
}
