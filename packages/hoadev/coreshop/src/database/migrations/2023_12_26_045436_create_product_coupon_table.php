<?php

use Hoadev\CoreShop\Models\Coupon;
use Hoadev\CoreShop\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_coupon', function (Blueprint $table) {
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Coupon::class);
/*             $table->unique(['product_id', 'voucher_id']); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_coupon');
    }
};
