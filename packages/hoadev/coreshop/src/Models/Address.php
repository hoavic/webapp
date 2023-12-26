<?php

namespace Hoadev\CoreShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
