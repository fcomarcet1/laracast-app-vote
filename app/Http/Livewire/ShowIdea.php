<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class ShowIdea extends Component
{
    public Idea $idea;
    public $votesCount;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
    }

    public function render()
    {
        return view('livewire.show-idea');
    }
}
