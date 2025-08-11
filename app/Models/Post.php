<?php

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\Filter\OrderFilter;
use ApiPlatform\Laravel\Eloquent\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as ApiPost;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new ApiPost(),
        new Put(),
        new Delete(),
    ],
    paginationEnabled: true,
    paginationItemsPerPage: 30
)]
class Post extends Entry
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $table = 'entries';

    protected $fillable = [
        'title',
        'content',
        'url',
        'user_id',
    ];

    protected $cascadeDeletes = ['comments', 'votes'];

    protected static function booted()
    {
        static::addGlobalScope('posts', function ($query) {
            $query->where('type', 'post');
        });

        static::creating(function ($post) {
            $post->type = 'post';
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Vote::class)->where('is_upvote', true);
    }

    public function downvotes()
    {
        return $this->hasMany(Vote::class)->where('is_upvote', false);
    }

    public function getScoreAttribute()
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }
}
