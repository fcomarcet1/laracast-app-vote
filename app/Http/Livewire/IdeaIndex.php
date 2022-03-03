<?php

namespace App\Http\Livewire;

use App\Exceptions\vote\DuplicateVoteException;
use App\Exceptions\vote\VoteNotFoundException;
use App\Models\Idea;
use Livewire\Component;

class IdeaIndex extends Component
{
    public Idea $idea;
    public $votesCount;
    public $hasVoted;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->voted_by_user; // voted_by_user is an index used in index action for addSelect
    }

    public function vote()
    {
        // check if user is not logged in and redirect to login page
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        // TODO: refactor this
        if ($this->hasVoted) {
            try {
                $this->idea->removeVote(auth()->user());
            } catch (VoteNotFoundException $e) {
                // do nothing
            }
            $this->votesCount--;
            $this->hasVoted = false;
        } else {
            try {
                $this->idea->addVote(auth()->user());
            } catch (DuplicateVoteException $e) {
                // do nothing
            }
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
