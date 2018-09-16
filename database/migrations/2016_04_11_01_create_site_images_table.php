<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSiteImages();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSiteImages();
    }
    
    public function createSiteImages()
    {
      Schema::create('site_images', function (Blueprint $table) {
          $table->increments('image_id');
          $table->string('image_site_id');
          $table->string('image_name')->unique();
          $table->tinyInteger('image_set_active');//which image to set on front end as active
      });
    }
    
    public function dropSiteImages(){
      Schema::dropIfExists('site_images');
    }
}
