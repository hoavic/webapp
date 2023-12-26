<?php

namespace Hoadev\CoreShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
/*  chua can thiet
    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    } */

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
