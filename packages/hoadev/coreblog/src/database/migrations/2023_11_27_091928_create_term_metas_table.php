<?php

use Hoadev\CoreBlog\Models\Term;
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
        Schema::create('term_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Term::class)->onDelete('cascade');
            $table->string('key');
            $table->longText('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_metas');
    }
};
