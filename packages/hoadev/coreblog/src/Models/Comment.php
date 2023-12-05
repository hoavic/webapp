<?php

namespace Hoadev\CoreBlog\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function commentMetas(): HasMany
    {
        return $this->hasMany(CommentMeta::class);
    }
}
