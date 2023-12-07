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
}
