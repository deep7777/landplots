<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createUom();
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
    
    public function createUom()
    {
     
      Schema::create('uom', function (Blueprint $table) {
        $table->increments('uom_id');
        $table->string('uom_name');
        $table->tinyInteger('uom_status');
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('uom');
    }
}
