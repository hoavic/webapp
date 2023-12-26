<?php

namespace Hoadev\CoreShop\Traits;

use Hoadev\CoreShop\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait WithProductRelationship {

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'author');
    }


}
