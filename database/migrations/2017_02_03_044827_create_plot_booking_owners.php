<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotBookingOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('plot_booking_owners', function (Blueprint $table) {
        $table->integer('plot_booking_id')->length(10)->unsigned();
        $table->integer('owner_id')->length(10)->unsigned();
      });
      
      Schema::table('plot_booking_owners', function($table) {
        $table->foreign('plot_booking_id')->references('plot_booking_id')->on('plot_booking');
        $table->foreign('owner_id')->references('owner_id')->on('plot_owner');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('plot_booking_owners');
    }
}
