<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('sectors', 'status')) {
            Schema::table('sectors', function (Blueprint $table) {
                $table->boolean('status')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sectors', 'status')) {
            Schema::table('sectors', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
