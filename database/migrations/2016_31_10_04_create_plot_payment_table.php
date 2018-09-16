<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPlotPayment();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop();
    }
    
    public function createPlotPayment()
    {
      Schema::create('plot_payment', function (Blueprint $table) {
        $table->increments('plot_payment_id');
        $table->integer('plot_booking_id')->length(10)->unsigned();
        $table->string('plot_payment_type');
        $table->tinyInteger('plot_payment_mode');
        $table->double('plot_payment_per')->nullable();
        $table->double('plot_payment_amount',15,2);
        $table->string('plot_payment_bank')->nullable();
        $table->string('plot_payment_cheque_number')->nullable();
        $table->date('plot_payment_date');
        $table->date('plot_payment_cheque_date')->nullable();
        $table->string('plot_payment_transaction_id')->nullable();
      });
      
      Schema::table('plot_payment', function($table) {
        $table->foreign('plot_booking_id')->references('plot_booking_id')->on('plot_booking');
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('plot_payment');
    }
}
