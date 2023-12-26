<?php

namespace Hoadev\CoreShop\Models;

use Hoadev\CoreBlog\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Post
{
    use HasFactory;

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'post_id');
    }

    public function productCategories() {

    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

}
