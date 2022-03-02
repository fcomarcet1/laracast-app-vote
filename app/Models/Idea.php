<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;

    public const PAGINATION_COUNT = 10;
    protected $guarded = [];

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'status_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    // ********** Relationships *************************
    /**
     * Get the user that owns the idea.
     */
    // One-to-Many: Idea-user.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the idea.
     */
    // One-to-Many: Idea-category.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the status that owns the idea.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get votes that owns the idea.
     */
    // Many-to-Many: Idea has many votes(unique by user_id).
    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }


    /**
     * Check if idea is voted by user(unique vote for every idea).
     */
    public function isVotedByUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();

        //return $user ? $this->votes->contains($user) : false;
    }

    /**
     * Add vote for Idea.
     */
    public function addVote(User $user): void
    {
        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Remove vote for Idea.
     */
    public function removeVote(User $user): void
    {
        Vote::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first()
            ->delete();
    }

}
