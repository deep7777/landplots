<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPartnerPayment();
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
    
    public function createPartnerPayment()
    {
      Schema::create('partner_payment', function (Blueprint $table) {
        $table->increments('partner_payment_id');
        $table->integer('partner_id')->length(10)->unsigned();
        $table->tinyInteger('partner_payment_mode');
        $table->double('partner_payment_per')->nullable();
        $table->double('partner_payment_amount',15,2);
        $table->string('partner_payment_bank')->nullable();
        $table->string('partner_payment_cheque_number')->nullable();
        $table->date('partner_payment_date');
        $table->date('partner_payment_cheque_date')->nullable();
        $table->string('partner_payment_transaction_id')->nullable();
      });
      
      Schema::table('partner_payment', function($table) {
        $table->foreign('partner_id')->references('partner_id')->on('partners');        
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('partner_payment');
    }
}
