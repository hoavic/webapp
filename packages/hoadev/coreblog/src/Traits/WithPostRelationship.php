<?php

namespace Hoadev\CoreBlog\Traits;

use Hoadev\CoreBlog\Models\Comment;
use Hoadev\CoreBlog\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait WithPostRelationship {

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
