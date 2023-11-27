<?php

use App\Models\User;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Post::class)->default(0);
            $table->tinyText('author');
            $table->string('author_email');
            $table->string('author_url')->nullable();
            $table->string('author_ip');
/*             $table->timestamp('date')->nullable();
            $table->timestamp('date_gmt')->nullable(); */
            $table->text('content');
            $table->integer('karma')->default(0);
            $table->integer('approved')->default(1);
            $table->string('agent')->nullable();
            $table->string('type')->default('comment');
            $table->bigInteger('parent')->default(0);
            $table->foreignIdFor(User::class)->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
