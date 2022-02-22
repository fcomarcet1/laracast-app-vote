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
        'user_id'
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the idea.
     */
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
    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

}
