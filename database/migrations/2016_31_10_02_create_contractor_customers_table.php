<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createContractorCustomers();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropContractorCustomers();
    }
    
    public function createContractorCustomers()
    {
      
      Schema::create('contractor_customers', function (Blueprint $table) {
          $table->increments('customer_id');
          $table->integer('contractor_site_id');
          $table->integer('contractor_id')->length(10)->unsigned();
          $table->string('contractor_work');
          $table->text('contractor_amount');
          $table->string('contractor_paid_amount');
          $table->timestamp('contractor_date');
      });
      
      Schema::table('contractor_customers', function($table) {
        $table->foreign('contractor_id')->references('contractor_id')->on('contractors');
      });
          
      
    }
    public function dropContractorCustomers(){
      Schema::dropIfExists('contractor_customers');
    }
}
