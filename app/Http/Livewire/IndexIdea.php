<?php

namespace App\Http\Livewire;

use Livewire\Component;

class IndexIdea extends Component
{
    public $idea;
    public $votesCount;

    public function mount($idea)
    {
        $this->idea = $idea;
        $this->votesCount = $idea->votes->count();
    }

    public function render()
    {
        return view('livewire.index-idea');
    }
}
