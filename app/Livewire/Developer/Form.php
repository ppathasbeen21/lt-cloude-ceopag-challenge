<?php

namespace App\Livewire\Developer;

use App\Models\Developer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $developerId;
    public $name;
    public $email;
    public $seniority;
    public $skills = [];
    public $skillInput = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:developers,email',
        'seniority' => 'required|in:Jr,Pl,Sr',
        'skills' => 'required|array|min:1',
    ];

    public function mount($developerId = null)
    {
        if ($developerId) {
            $developer = Developer::findOrFail($developerId);
            $this->developerId = $developer->id;
            $this->name = $developer->name;
            $this->email = $developer->email;
            $this->seniority = $developer->seniority;
            $this->skills = $developer->skills;
        }
    }

    public function addSkill()
    {
        if ($this->skillInput) {
            $this->skills[] = $this->skillInput;
            $this->skillInput = '';
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function save()
    {
        if ($this->developerId) {
            $this->rules['email'] = 'required|email|unique:developers,email,' . $this->developerId;
        }

        $this->validate();

        Developer::updateOrCreate(
            ['id' => $this->developerId],
            [
                'user_id' => Auth::id(),
                'name' => $this->name,
                'email' => $this->email,
                'seniority' => $this->seniority,
                'skills' => $this->skills,
            ]
        );

        session()->flash('message', 'Developer saved successfully!');
        return redirect()->route('developers.index');
    }

    public function render()
    {
        return view('livewire.developer.form');
    }
}
