<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMeta extends Model
{
    use HasFactory;

    protected $table = 'post_metas';

    public $timestamps = false;

    protected $fillable = [

    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
