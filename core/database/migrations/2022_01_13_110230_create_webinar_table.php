<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('webinar_code');
            $table->string('coach_code')->nullable();
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->string('post_code')->nullable();
            $table->string('duration');
            $table->string('title');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
        Schema::create('webinar_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('webinar_code');
            $table->string('prinicpal_code')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->string('webinar_code');
        });
     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinar');
    }
}
