<?php

namespace App\Livewire\Developer;

use App\Models\Developer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $skillFilter = '';
    public $seniorityFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSkillFilter()
    {
        $this->resetPage();
    }

    public function updatingSeniorityFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $developers = Developer::query()
            ->with('articles')
            ->when($this->search, function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->when($this->skillFilter, function($query) {
                $query->whereJsonContains('skills', $this->skillFilter);
            })
            ->when($this->seniorityFilter, function($query) {
                $query->where('seniority', $this->seniorityFilter);
            })
            ->paginate(10);

        return view('livewire.developer.index', [
            'developers' => $developers
        ]);
    }
}
