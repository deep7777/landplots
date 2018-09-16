<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createCompany();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropCompany();
    }
    
    public function createCompany()
    {
      Schema::create('company', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->unique();
          $table->string('email')->unique();
          $table->string('mobile_no')->unique();
          $table->string('office_no')->unique();
          $table->string('logo');
          $table->text('pincode');
          $table->text('address');
          $table->timestamp('created_on');
      });
    }
    
   
    public function dropCompany(){
      Schema::dropIfExists('company');
    }
}
