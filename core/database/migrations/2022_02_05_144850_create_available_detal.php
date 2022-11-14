<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableDetal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_availability_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avail_code');
            $table->string('date')->nullable();
            $table->longText('time_slots_15')->nullable();
            $table->longText('time_slots_30')->nullable();
            $table->longText('time_slots_60')->nullable();
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
        Schema::dropIfExists('available_detal');
    }
}
