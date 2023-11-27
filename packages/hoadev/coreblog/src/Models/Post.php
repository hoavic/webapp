<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [

    ];

    public function postMetas(): HasMany
    {
        return $this->hasMany(PostMeta::class);
    }

    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class);
    }

}
