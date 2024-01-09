<?php

namespace Hoadev\CoreBlog\Models;

use Hoadev\CoreBlog\Traits\Seo\WithSeoTermFunc;
use Hoadev\CoreShop\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Term extends Model
{
    use HasFactory, WithSeoTermFunc;

    protected $table = 'terms';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'group'
    ];

    public function taxonomy(): HasOne
    {
        return $this->hasOne(Taxonomy::class);
    }

    public function termMetas(): HasMany
    {
        return $this->hasMany(TermMeta::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'term_relationships', 'post_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'term_relationships', 'term_id', 'post_id', 'id', 'id', 'posts');
    }

    public function getPermalink() {
        if ($this->taxonomy->taxonomy === 'category') {
            return $this->parseSlug();
        }
        return '/'.$this->taxonomy->taxonomy.$this->parseSlug();
    }

    public function parseSlug() {
        $ancestors = $this->taxonomy->ancestors;
        $slug = '';
        foreach($ancestors as $ancestor) {
            $slug = $slug.'/'.$ancestor->term->slug;
        }
        return $slug.'/'.$this->slug;
    }

    public function getExcerpt($limit = 50, $append = ' ...') {
        if(!$this->taxonomy->description) {
            return '';
        }
        return $this->limit_words(strip_tags($this->taxonomy->description), $limit, $append);

    }

    function limit_words($words, $limit, $append = ' ...') {
            // Add 1 to the specified limit becuase arrays start at 0
            $limit = $limit+1;
            // Store each individual word as an array element
            // Up to the limit
            $words = explode(' ', $words, $limit);
            // Shorten the array by 1 because that final element will be the sum of all the words after the limit
            array_pop($words);
            // Implode the array for output, and append an ellipse
            $words = implode(' ', $words) . $append;
            // Return the result
            return $words;
    }
}
