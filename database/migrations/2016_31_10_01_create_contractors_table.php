<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createContractors();
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
    
    public function createContractors()
    {
      
      Schema::create('contractors', function (Blueprint $table) {
          $table->increments('contractor_id');
          $table->string('contractor_first_name');
          $table->string('contractor_last_name');
          $table->string('contractor_email');
          $table->string('contractor_mobile_no');
          $table->text('contractor_address');
          $table->timestamp('created_on');
      });
    }
    public function drop(){
      Schema::dropIfExists('contractors');
    }
}
