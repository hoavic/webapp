<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory;

    protected $table = 'terms';

    public $timestamps = false;

    protected $fillable = [

    ];

    public function termMetas(): HasMany
    {
        return $this->hasMany(TermMeta::class);
    }
}
