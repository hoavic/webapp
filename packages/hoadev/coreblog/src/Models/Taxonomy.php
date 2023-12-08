<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

class Taxonomy extends Model
{
    use HasFactory, NodeTrait;

    protected $table = 'taxonomies';

    public $timestamps = false;

    protected $fillable = [
        'taxonomy',
        'description',
        'parent_id',
        'count'
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

/*     public function parent(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    } */
}
