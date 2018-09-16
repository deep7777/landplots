<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createVisitor();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropVisitor();
    }
    
    public function createVisitor()
    {
      Schema::create('visitor', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('visitor_site_id');
          $table->integer('visitor_media_id');
          $table->string('first_name');
          $table->string('middle_name')->nullable();
          $table->string('last_name')->nullable();
          $table->string('email')->nullable();
          $table->string('mobile_no')->nullable();
          $table->text('address')->nullable();
          $table->string('vehicle_no')->nullable();
          $table->timestamp('visited_on')->nullable();
      });
    }
    
   
    public function dropVisitor(){
      Schema::dropIfExists('visitor');
    }
}
