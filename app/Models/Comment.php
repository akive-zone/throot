<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

#[ApiResource]
class Comment extends Entry
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['comments'];


    public function comments()
    {
        return $this->hasMany(self::class);
    }
}
