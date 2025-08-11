<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post as ApiPost;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new ApiPost(),
        new Put(),
        new Delete(),
    ],
)]
class Entry extends Model
{
    use SoftDeletes;

    protected $table = 'entries';

    protected $fillable = [
        'title',
        'content',
        'url',
        'data',
        'user_id',
        'entity_id',
        'entity_type_id',
        'post_id',
        'parent_id',
        'type',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function entityType()
    {
        return $this->belongsTo(EntityType::class);
    }

    public function post()
    {
        return $this->belongsTo(Entry::class, 'post_id');
    }

    public function parent()
    {
        return $this->belongsTo(Entry::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Entry::class, 'parent_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id');
    }
}
