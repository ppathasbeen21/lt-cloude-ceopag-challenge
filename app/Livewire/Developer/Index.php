<?php

namespace App\Livewire\Developer;

use App\Models\Developer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $skillFilter = '';
    public $seniorityFilter = '';
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
        $developer = Developer::where('id', $this->deleteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $developer->articles()->detach();
        $developer->delete();

        $this->deleteId = null;
        session()->flash('message', 'Desenvolvedor excluído com sucesso!');
    }

    public function render()
    {
        $developers = Developer::query()
            ->with('articles')
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->skillFilter, function ($query) {
                $query->whereJsonContains('skills', $this->skillFilter);
            })
            ->when($this->seniorityFilter, function ($query) {
                $query->where('seniority', $this->seniorityFilter);
            })
            ->paginate(9);

        return view('livewire.developer.index', compact('developers'))
            ->layout('layouts.livewire');
    }
}
