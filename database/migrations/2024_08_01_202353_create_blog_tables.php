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
            $table->string('notion_page_id')->index();
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
    }
};
