<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChatTableChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->string('message_subject')->after('chat_hostory')->nullable();
            $table->string('description')->after('chat_hostory')->nullable();
            $table->string('note')->after('chat_hostory')->nullable();
            $table->string('last_reply')->after('chat_hostory')->nullable();
            $table->integer('coach_replied')->after('chat_hostory')->nullable();
            $table->integer('principal_replied')->after('chat_hostory')->nullable();
        });

        Schema::table('chat_messages_report', function (Blueprint $table) {
            $table->string('message_subject')->after('chat_hostory')->nullable();
            $table->string('message_description')->after('chat_hostory')->nullable();
            $table->string('note')->after('chat_hostory')->nullable();
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
