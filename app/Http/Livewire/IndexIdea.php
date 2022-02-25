<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IndexIdea extends Component
{
    public Idea $idea;
    public $votesCount;
    public $hasVoted;

    public function mount(Idea $idea, $votesCount, )
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->voted_by_user; // voted_by_user is an index used in index action for addSelect
    }

    public function render()
    {
        return view('livewire.index-idea');
    }
}
