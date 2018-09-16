<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPartners();
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
    
    public function createPartners()
    {
      Schema::create('partners', function (Blueprint $table) {
          $table->increments('partner_id');
          $table->integer('site_id');
          $table->string('partner_first_name');
          $table->string('partner_middle_name')->nullable();
          $table->string('partner_last_name');
          $table->string('partner_mobile_no');
          $table->string('partner_email')->nullable();
          $table->string('partner_address');
          $table->double('partner_percentage');
          $table->double('partner_amount',15,2);
          $table->timestamp('partner_next_payment_date')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('partners');
    }
}
