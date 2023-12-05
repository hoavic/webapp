<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Taxonomy extends Model
{
    use HasFactory;

    protected $table = 'taxonomies';

    public $timestamps = false;

    protected $fillable = [

    ];

    public function term(): HasOne
    {
        return $this->hasOne(Term::class);
    }
}
