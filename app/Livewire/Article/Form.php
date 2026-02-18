<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $articleId;
    public $title;
    public $slug;
    public $content;
    public $published_at;
    public $category_id;
    public $cover_image;
    public $existingCover;
    public $selectedDevelopers = [];

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|unique:articles,slug,' . ($this->articleId ?? 'NULL'),
            'content' => 'required|min:10',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|max:2048',
            'selectedDevelopers' => 'nullable|array',
        ];
    }

    public function mount($articleId = null)
    {
        if ($articleId) {
            $article = Article::where('id', $articleId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $this->articleId = $article->id;
            $this->title = $article->title;
            $this->slug = $article->slug;
            $this->content = $article->content;
            $this->published_at = $article->published_at?->format('Y-m-d\TH:i');
            $this->category_id = $article->category_id;
            $this->existingCover = $article->cover_image;
            $this->selectedDevelopers = $article->developers->pluck('id')->toArray();
        }
    }

    public function updatedTitle($value)
    {
        if (!$this->articleId) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $coverPath = $this->existingCover;

        if ($this->cover_image) {
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }
            $coverPath = $this->cover_image->store('covers', 'public');
        }

        $article = Article::updateOrCreate(
            ['id' => $this->articleId],
            [
                'user_id' => Auth::id(),
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content,
                'published_at' => $this->published_at ?: null,
                'category_id' => $this->category_id,
                'cover_image' => $coverPath,
            ]
        );

        $article->developers()->sync($this->selectedDevelopers ?? []);

        session()->flash('message', 'Artigo salvo com sucesso!');
        return redirect()->route('articles.index');
    }

    public function removeCover()
    {
        if ($this->existingCover) {
            Storage::disk('public')->delete($this->existingCover);
            Article::where('id', $this->articleId)->update(['cover_image' => null]);
            $this->existingCover = null;
        }
    }

    public function render()
    {
        return view('livewire.article.form', [
            'categories' => Category::orderBy('name')->get(),
            'developers' => Developer::where('user_id', Auth::id())->orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
