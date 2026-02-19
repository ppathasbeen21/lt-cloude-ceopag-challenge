<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $developerFilter = '';
    public $deleteId = null;

    protected $paginationTheme = 'bootstrap';

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $article = Article::where('id', $this->deleteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->developers()->detach();
        $article->delete();

        $this->deleteId = null;
        session()->flash('message', 'Artigo excluído com sucesso!');
    }

    public function render()
    {
        $articles = Article::query()
            ->with(['developers', 'category'])
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('slug', 'like', "%{$this->search}%");
            })
            ->when($this->developerFilter, function ($query) {
                $query->whereHas('developers', function ($q) {
                    $q->where('developers.id', $this->developerFilter);
                });
            })
            ->latest()
            ->paginate(9);

        $developers = Developer::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('livewire.article.index', compact('articles', 'developers'))
            ->layout('layouts.livewire');
    }
}
