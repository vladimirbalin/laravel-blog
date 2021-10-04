<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserToFollowedUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_to_followed_user', function (Blueprint $table) {
            $table->primary(['user_id', 'followed_user_id']);

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('followed_user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('followed_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_to_followed_user');
    }
}
