<?php

use Hoadev\CoreBlog\Models\Comment;
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
        Schema::create('comment_metas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Comment::class)->onDelete('cascade');
            $table->string('key');
            $table->longText('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_metas');
    }
};
