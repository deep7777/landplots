<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createMedia();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropMedia();
    }
    
    public function createMedia()
    {
      Schema::create('media', function (Blueprint $table) {
          $table->increments('media_id');
          $table->string('media_name')->unique();
          $table->timestamp('created_on');
      });
    }
    
    public function dropMedia(){
      Schema::dropIfExists('media');
    }
}
