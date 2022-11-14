<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatHistoryReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_code')->nullable();
            $table->string('principal_code')->nullable();
            $table->string('coach_code')->nullable();
            $table->string('description')->nullable();
            $table->json('chat_hostory');
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
        Schema::dropIfExists('_chat_history_report');
    }
}
