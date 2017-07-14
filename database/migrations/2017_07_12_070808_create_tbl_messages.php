<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->integer('participants_id')->unsigned();
            $table->foreign('conversation_id')->references('id')->on('conversation');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('participants_id')->references('id')->on('participants');
            $table->enum('message_type', ['text', 'image', 'vedio', 'audio'])->default('text');
            $table->string('message', 255);
            $table->timestamp('created_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');

    }
}
