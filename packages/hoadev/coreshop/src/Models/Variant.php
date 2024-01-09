<?php

namespace Hoadev\CoreShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'post_id', 'stock_id', 'name', 'sku', 'barcode', 'quantity', 'price'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'post_id');
    }

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class);
    }

    //Data format

    public function getPrice($currency = 'đ') {
        if(!$this->price) {return 'Liên hệ';}
        if($this->price == 0 || $this->price === "0") {return 'Miễn phí';}
        return number_format($this->price,0,',','.').' '.$currency;
    }

    public function getStock() {
        if(!$this->stock || $this->stock == 0 || $this->price === "0") {return 'Liên hệ';}
        return number_format($this->stock,0,',','.');
    }

}
