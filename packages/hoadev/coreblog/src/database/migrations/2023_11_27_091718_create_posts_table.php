<?php

use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->bigInteger('author')->nullable()->default(0); */
            $table->foreignIdFor(User::class, 'author')->nullable()->default(0);
/*             $table->timestamp('date');
            $table->timestamp('date_gmt'); */
            $table->longText('content')->nullable();
            $table->text('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('status')->nullable()->default('publish');
            $table->string('comment_status')->nullable()->default('open');
            $table->string('ping_status')->nullable()->default('open');
            $table->string('password')->nullable();
            $table->string('name')->unique();
            $table->text('to_ping')->nullable();
            $table->text('pinged')->nullable();
/*             $table->timestamp('modified');
            $table->timestamp('modified_gmt'); */
            $table->longText('post_content_filtered')->nullable();
            $table->bigInteger('parent')->nullable()->default(0);
            $table->string('guid')->nullable();
            $table->integer('menu_order')->nullable();
            $table->string('type')->nullable()->default('post');
            $table->string('post_mine_type')->nullable();
            $table->bigInteger('comment_count')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
