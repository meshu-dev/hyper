<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wp_post_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_category_id');
            $table->string('name');
        });

        Schema::create('wp_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_post_id');
            $table->unsignedBigInteger('wp_category_id');
            $table->string('title');
            $table->string('slug');
            $table->mediumText('content');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wp_post_categories');
        Schema::dropIfExists('wp_posts');
    }
};
