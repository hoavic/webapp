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
    //Alter == the same == term_taxonomy in wp
    public function up(): void
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Term::class);
            $table->string('taxonomy');
            $table->longText('description')->nullable();
/*             $table->bigInteger('parent_id')->default(0); */
            $table->bigInteger('count');
            $table->nestedSet();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxonomies', function (Blueprint $table) {
            $table->dropNestedSet();
        });
    }
};
