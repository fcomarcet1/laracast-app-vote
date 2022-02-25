<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class ShowIdea extends Component
{
    public Idea $idea;
    public $votesCount;
    public $hasVoted;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function render()
    {
        return view('livewire.show-idea');
    }
}
