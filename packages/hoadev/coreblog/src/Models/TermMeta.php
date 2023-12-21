<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermMeta extends Model
{
    use HasFactory;

    protected $table = 'term_metas';

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value'
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'value');
    }
}
