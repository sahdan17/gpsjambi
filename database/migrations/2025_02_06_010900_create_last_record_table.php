<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lastRecord', function (Blueprint $table) {
            $table->string('lat');
            $table->string('long');
            $table->float('speed');
            $table->integer('sat');
            $table->enum('status', ['start', 'stop', 'idle']);
            $table->unsignedInteger('idDevice')->primary();
            $table->dateTime('timestamp');

            $table->foreign('idDevice')
                  ->references('id')->on('vehicle')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('record', function (Blueprint $table) {
            $table->dropForeign(['idDevice']);
        });

        Schema::dropIfExists('record');
    }
};
