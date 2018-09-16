<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotBookingEmiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('plot_booking_emi', function(Blueprint $table)
      {
        $table->increments('emi_id');
        $table->integer('plot_booking_id'); 
        $table->double('emi_per',15,2)->nullable(); 
        $table->double('emi_amount',15,4); 
        $table->date('emi_date'); 
        $table->string('emi_cheque_number')->nullable(); 
        $table->date('emi_cheque_date')->nullable(); 
        $table->string('emi_bank')->nullable(); 
        $table->string('emi_transaction_id')->nullable(); 
        $table->double('emi_amount_paid',15,4)->nullable(); 
        $table->tinyInteger('emi_status')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('plot_booking_emi');
    }
}
