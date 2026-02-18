<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $name = '';
    public $deleteId = null;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|min:2|max:100|unique:categories,name',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        $this->name = '';
        $this->showForm = false;
        session()->flash('message', 'Categoria criada com sucesso!');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Category::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
        session()->flash('message', 'Categoria excluída com sucesso!');
    }

    public function render()
    {
        return view('livewire.category.index', [
            'categories' => Category::withCount('articles')->orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
