<?php

use Hoadev\CoreBlog\Models\Post;
use Hoadev\CoreBlog\Models\Term;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // same term_relationships in wp
    public function up(): void
    {
        Schema::create('term_relationships', function (Blueprint $table) {
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(Term::class, 'taxonomy_id');
            $table->string('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_relationships');
    }
};
