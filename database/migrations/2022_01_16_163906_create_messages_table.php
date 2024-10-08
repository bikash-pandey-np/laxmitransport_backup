<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_group_id');
            $table->string('message')->nullable();
            $table->string('file_type')->default('image');
            $table->string('file')->nullable();
            $table->string('sender_type');
            $table->unsignedBigInteger('sender_id');
            $table->boolean('seen')->default(0);
            $table->string('message_user_type');
            $table->unsignedBigInteger('message_user_id');
            $table->timestamps();
            $table->foreign('chat_group_id')->on('chat_groups')->references('id') ->onDelete('cascade');
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
