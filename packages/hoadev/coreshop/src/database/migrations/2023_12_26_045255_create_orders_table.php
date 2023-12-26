<?php

use Hoadev\CoreShop\Models\Customer;
use Hoadev\CoreShop\Models\Payment;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Payment::class);
            $table->string('status');
            $table->integer('sub_total')->default(0);
            $table->integer('total_item')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
