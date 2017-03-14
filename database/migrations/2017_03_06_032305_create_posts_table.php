<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->text('html_body');
            $table->integer('user_id')->unsigned();//发表帖子的用户
            $table->integer('last_user_id')->unsigned();//更新帖子的用户
            $table->integer('comment_count')->default(0);//评论数
            $table->integer('vote_count')->default(0);//点赞数
            $table->string('is_first',8)->default('F');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
