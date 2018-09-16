<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSites();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSite();
    }
    
    public function createSites()
    {
      Schema::create('sites', function (Blueprint $table) {
          $table->increments('site_id');
          $table->string('site_name')->unique();
          $table->string('site_email');
          $table->string('site_contact_person');
          $table->string('site_mobile_no');
          $table->string('site_telephone_no');
          $table->text('site_address');
          $table->string('site_pincode');
          $table->string('site_area');
          $table->string('site_total_plots');
          $table->integer('site_plot_rate_per_sqft');
          $table->double('site_cost',15,2);
          $table->double('area_width_top');
          $table->double('area_width_bottom');
          $table->double('area_height_left');
          $table->double('area_height_right');
          $table->tinyInteger('site_status_id')->nullable();//complete || ongoing || future
          $table->timestamp('created_on');
          $table->double('site_plots_area',15,4)->nullable();
          $table->double('site_road_area',15,4)->nullable();
      });
    }
    
    public function dropSite(){
      Schema::dropIfExists('sites');
    }
}
