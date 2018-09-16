<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('plot_booking', function (Blueprint $table) {
        $table->increments('plot_booking_id');
        $table->integer('site_id');
        $table->date('plot_booking_date');
        $table->string('plot_booking_area');
        $table->string('plot_booking_cost');
        $table->integer('plot_booking_rate_per_sqft');
        $table->string('next_payment_date')->nullable();
        $table->tinyInteger('plot_emi_taken')->nullable();
        $table->tinyInteger('plot_emi_installments')->nullable();
        $table->date('plot_emi_start_date')->nullable();
        $table->timestamp('created_on')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('plot_booking');
    }
}
