<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Term extends Model
{
    use HasFactory;

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

    public function getPermalink() {
        if ($this->taxonomy->taxonomy === 'category') {
            return $this->parseSlug();
        }
        return $this->taxonomy->taxonomy.'/'.$this->parseSlug();
    }

    public function parseSlug() {
        $ancestors = $this->taxonomy->ancestors;
        $slug = '';
        foreach($ancestors as $ancestor) {
            $slug = $slug.'/'.$ancestor->term->slug;
        }
        return $slug.'/'.$this->slug;
    }
}
