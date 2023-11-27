<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentMeta extends Model
{
    use HasFactory;

    protected $table = 'comment_metas';

    public $timestamps = false;

    protected $fillable = [

    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
