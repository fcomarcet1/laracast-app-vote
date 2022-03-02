<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class IdeaCreate extends Component
{
    public $title;
    public $description;
    public $category = 1;

    protected array $rules = [
        'title' => 'required|min:4',
        'description' => 'required|min:4',
        'category' => 'required|integer|min:1',
    ];

    public function createIdea()
    {
        if (auth()->check()){
            $this->validate();
            $idea = Idea::create([
                'title' => $this->title,
                'description' => $this->description,
                'category_id' => $this->category,
                'user_id' => auth()->user()->id,
                'status_id' => 1,
            ]);
            //dd($idea);

            // TODO: test this
            if (!$idea) {
                session()->flash('message', 'Idea not created');
                return redirect()->back()->withErrors([
                    'message' => 'Idea could not be created.',
                ]);
            }
            session()->flash('message', 'Idea created successfully');
            $this->reset();

            return redirect()->route('idea.index');
        }
        abort(Response::HTTP_FORBIDDEN);
    }

    public function render()
    {
        return view('livewire.idea-create', [
            'categories' => Category::all(),
        ]);
    }
}
