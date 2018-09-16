<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotBookingOwnerPlots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('plot_booking_owner_plots', function (Blueprint $table) {
        $table->integer('plot_booking_id')->length(10)->unsigned();
        $table->integer('plot_id')->length(10)->unsigned();
      });
      
      Schema::table('plot_booking_owner_plots', function($table) {
        $table->foreign('plot_booking_id')->references('plot_booking_id')->on('plot_booking');
        $table->foreign('plot_id')->references('plot_id')->on('plots');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('plot_booking_owner_plots');
    }
}
