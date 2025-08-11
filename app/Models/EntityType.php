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
class EntityType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'schema',
        'settings',
        'entity_id',
    ];

    protected $casts = [
        'schema' => 'array',
        'settings' => 'array',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}