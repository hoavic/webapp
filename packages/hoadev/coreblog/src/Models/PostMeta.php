<?php

namespace Hoadev\CoreBlog\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        if($this->value) {dd($this->value);}
        if(preg_match('/\{.*\}/', $this->value, $matches)) {dd($this->value);}
        return $this->belongsTo(Media::class, 'value');
    }

/*     public function getValueAttribute($value) {
        if($value == null) {return $value;}
        $patt = '/\{.*\}/';

        if(preg_match($patt, $value, $matches)) {return json_decode($value, true);}

        return $value;
    } */

    function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (preg_match('/\{.*\}/', $value, $matches)) ? json_decode($value) : $value,

            set: fn ($value) => is_array($value) ? json_encode($value) : $value,
        );
    }
}
