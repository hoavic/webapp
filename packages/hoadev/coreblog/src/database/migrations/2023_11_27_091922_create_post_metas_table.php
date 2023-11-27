<?php

use Hoadev\CoreBlog\Models\Post;
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
        Schema::create('post_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Post::class)->onDelete('cascade');
            $table->string('key');
            $table->longText('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_metas');
    }
};
