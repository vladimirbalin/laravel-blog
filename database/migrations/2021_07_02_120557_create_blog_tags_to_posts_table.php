<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags_to_posts', function (Blueprint $table) {
            $table->primary(['tag_id', 'post_id']);

            $table->integer('tag_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('blog_tags');
            $table->foreign('post_id')->references('id')->on('blog_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_tags_to_posts');
    }
}
