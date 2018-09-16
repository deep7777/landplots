<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createItem();
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
    
    public function createItem()
    {
     
      Schema::create('item', function (Blueprint $table) {
        $table->increments('item_id');
        $table->string('item_code')->nullable();
        $table->string('item_name')->nullable();
        $table->Integer('uom_id')->nullable();
        $table->Integer('rate')->nullable();
        $table->text('item_desc')->nullable();
        $table->tinyInteger('item_status')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('item');
    }
}
