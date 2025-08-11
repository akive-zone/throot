<?php

namespace App\Structs;

class Post {

    public function __construct(
        public string $title,
        public string $content,
        public ?string $author = null,
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) { }
}
