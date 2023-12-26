<?php

use Hoadev\CoreShop\Models\Customer;
use Hoadev\CoreShop\Models\Order;
use Hoadev\CoreShop\Models\Shipping;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Order::class);
            $table->string('type')->default('cod');
            $table->string('status')->default('pending');
            $table->integer('amount')->nullable()->default(0);
            $table->integer('fee')->default(0);
            $table->integer('total')->default(0);
            $table->integer('paid')->default(0);
            $table->integer('remaining_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
