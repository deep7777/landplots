<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSiteStatus();
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
    
    public function createSiteStatus()
    {
     
      Schema::create('site_status', function (Blueprint $table) {
        $table->increments('site_status_id');
        $table->string('site_status_name');
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('site_status');
    }
}
