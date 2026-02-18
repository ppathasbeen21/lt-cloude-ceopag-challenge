<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteId = null;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
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
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('slug', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(9);

        return view('livewire.article.index', compact('articles'))
            ->layout('layouts.app');
    }
}
