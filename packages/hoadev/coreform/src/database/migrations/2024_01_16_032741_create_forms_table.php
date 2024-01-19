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
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('status')->nullable()->default('accepted');
            $table->string('type')->nullable()->default('contact_form');
            $table->string('contact_name');
            $table->string('contact_address');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
