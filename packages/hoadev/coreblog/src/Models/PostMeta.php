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
        'id',
        'post_id',
        'key',
        'value'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id', 'post');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'value');
    }
}
