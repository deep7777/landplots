<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPlotOwner();
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
    
    public function createPlotOwner()
    {
      Schema::create('plot_owner', function (Blueprint $table) {
        $table->increments('owner_id');
        $table->integer('plot_booking_id')->length(10)->unsigned();
        $table->string('owner_first_name');
        $table->string('owner_middle_name');
        $table->string('owner_last_name');
        $table->string('owner_mobile_no');
        $table->string('owner_email')->nullable();
        $table->string('owner_address');
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('plot_owner');
    }
}
