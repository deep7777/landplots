<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPlots();
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
    
    public function createPlots()
    {
      
      Schema::create('plots', function (Blueprint $table) {
          $table->increments('plot_id');
          $table->integer('site_id')->length(10)->unsigned();
          $table->string('plot_name');
          $table->string('site_plot_name')->unique();
          $table->text('plot_address')->nullable();
          $table->string('plot_no')->nullable();
          $table->string('plot_area')->nullable();
          $table->integer('plot_rate_per_sqft')->nullable();
          $table->double('plot_basic_cost',15,2)->nullable();
          $table->double('plot_cost',15,2)->nullable();
          $table->double('plot_service_tax',8,2)->nullable();
          $table->tinyInteger('plot_booked')->nullable();
          $table->timestamps();
      });
      
      Schema::table('plots', function($table) {
        $table->foreign('site_id')->references('site_id')->on('sites');
      });
    }
    /*
     * 
     */
    public function dropPlot(){
      Schema::dropIfExists('plots');
    }
}
