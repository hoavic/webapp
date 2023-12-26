<?php

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');

            // The voucher code
            $table->string('code')->nullable();

            // The human readable voucher code name
            $table->string('name');

            // The description of the voucher - Not necessary
            $table->text('description')->nullable();

            // The number of uses currently
            $table->integer('uses')->unsigned()->nullable();

            // The max uses this voucher has
            $table->integer('max_uses')->unsigned()->nullable();

            // How many times a user can use this voucher.
            $table->integer('max_uses_user')->unsigned()->nullable();

            // The type can be: voucher, discount, sale. What ever you want.
            $table->tinyInteger('type')->unsigned();

            // The amount to discount by (in pennies) in this example.
            $table->integer('discount_amount');

            // Whether or not the voucher is a percentage or a fixed price.
            $table->boolean('is_fixed')->default(true);

            // When the voucher begins
            $table->timestamp('starts_at');

            // When the voucher ends
            $table->timestamp('expires_at');

            // You know what this is...
            $table->timestamps();

            // We like to horde data.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
