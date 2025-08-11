<?php

namespace App\Http\Api\Resources;

use ApiPlatform\Metadata\Get;

#[Get(uriTemplate: '/posts/{id}')]
class Post
{
    public function __construct(
        public string $id,
        public string $title
    ) {}
}
