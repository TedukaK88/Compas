<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('id');
            $table->integer('like_user_id')->comment('いいねした人のid');
            $table->integer('like_post_id')->comment('いいねした投稿のid');
            $table->timestamp('created_at')->default(DB::raw('current_timestamp on update current_timestamp'))->comment('登録日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}