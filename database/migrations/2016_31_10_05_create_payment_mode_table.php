<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPaymentMode();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropPlot();
    }
    
    public function createPaymentMode()
    {
      Schema::create('payment_mode', function (Blueprint $table) {
          $table->increments('payment_mode_id');
          $table->string('payment_mode_name')->unique();
      });
    }
    /*
     * 
     */
    public function dropPlot(){
      Schema::dropIfExists('payment_mode');
    }
}
