<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
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

    // Attribute

    protected function count(): Attribute
    {
/*         return Attribute::make(
            get: fn (string $value) => $this->term->posts->count(),
        ); */
        return Attribute::make(
            get: fn (string $value) => Cache::tags(['terms', 'taxonomies', 'posts'])->remember('taxonomy:'.$this->term->slug.':count', 3600, function() {
                return $this->term->posts->count();
            }),
        );
    }

    // Format Data

    public function getPermalink() {
        if ($this->taxonomy === 'category') {
            return $this->parseSlug();
        }
        $term_slug = config('coreblog.taxonomies.'.$this->taxonomy.'.rewrite') ?? config('coreblog.taxonomies.'.$this->taxonomy.'.taxonomy');
        return '/'.$term_slug.$this->parseSlug();
    }

    public function parseSlug() {
        $ancestors = $this->ancestors;
        $slug = '';
        foreach($ancestors as $ancestor) {
            $slug = $slug.'/'.$ancestor->term->slug;
        }
        return $slug.'/'.$this->term->slug;
    }
}
