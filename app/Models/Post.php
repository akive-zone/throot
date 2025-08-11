<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Post extends Entry
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['comments'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
