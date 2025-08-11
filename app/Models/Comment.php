<?php

namespace App\Models;

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
)]
class Comment extends Entry
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $table = 'entries';

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'parent_id',
    ];

    protected $cascadeDeletes = ['comments'];

    protected static function booted()
    {
        static::addGlobalScope('comments', function ($query) {
            $query->where('type', 'comment');
        });

        static::creating(function ($comment) {
            $comment->type = 'comment';
        });
    }

    public function comments()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
