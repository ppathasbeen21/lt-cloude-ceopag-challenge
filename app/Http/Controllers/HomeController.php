<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        $devCount = Developer::where('user_id', $userId)->count();
        $articleCount = Article::where('user_id', $userId)->count();
        $publishedCount = Article::where('user_id', $userId)->whereNotNull('published_at')->count();
        $draftCount = Article::where('user_id', $userId)->whereNull('published_at')->count();

        $latestArticles = Article::with('developers')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $topDevelopers = Developer::withCount(['articles' => function ($q) use ($userId) {
            $q->where('articles.user_id', $userId);
        }])
            ->where('user_id', $userId)
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return view('home', compact(
            'devCount',
            'articleCount',
            'publishedCount',
            'draftCount',
            'latestArticles',
            'topDevelopers'
        ));
    }
}
