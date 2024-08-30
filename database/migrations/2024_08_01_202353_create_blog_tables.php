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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->index();
            $table->morphs('blogable');
            $table->text('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('status');
            $table->date('published_at')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('site_id')->references('id')->on('sites');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->index();
            $table->string('notion_tag_id')->index();
            $table->string('name');
            $table->string('color');

            $table->foreign('site_id')->references('id')->on('sites');
        });

        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('blog_id')->references('id')->on('blogs');
            $table->foreign('tag_id')->references('id')->on('tags');
        });

        Schema::create('notion_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('notion_page_id')->index();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });

        Schema::create('wp_blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_post_id');
            $table->unsignedBigInteger('wp_category_id');
            $table->timestamp('updated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('blog_tags');
        Schema::dropIfExists('notion_blogs');
        Schema::dropIfExists('wp_blogs');
    }
};
