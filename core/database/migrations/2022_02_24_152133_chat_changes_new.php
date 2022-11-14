<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChatChangesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('technical_user_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->json('chat_history')->nullable();
            $table->string('note')->nullable();
            $table->string('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('last_reply')->nullable();
            $table->integer('technical_replied')->nullable();
            $table->integer('principal_replied')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('technical_chat_messages_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('technical_user_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->string('description')->nullable();
            $table->json('chat_history')->nullable();
            $table->string('note')->nullable();
            $table->string('message_description')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('feedback_chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('admin_user_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->json('chat_history')->nullable();
            $table->string('note')->nullable();
            $table->string('description')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('other_chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('admin_user_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->json('chat_history')->nullable();
            $table->string('note')->nullable();
            $table->string('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('last_reply')->nullable();
            $table->integer('admin_replied')->nullable();
            $table->integer('principal_replied')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('other_chat_messages_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('admin_user_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->json('chat_history')->nullable();
            $table->string('note')->nullable();
            $table->string('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('message_description')->nullable();
            $table->string('last_reply')->nullable();
            $table->integer('admin_replied')->nullable();
            $table->integer('principal_replied')->nullable();
            $table->boolean('status')->default(1);
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
        //
    }
}
