<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $this->createEmployee();
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
    
    public function createEmployee()
    {
      Schema::create('employees', function (Blueprint $table) {
        $table->increments('emp_id');
        $table->string('emp_first_name');
        $table->string('emp_last_name')->nullable();
        $table->Integer('emp_site_id')->nullable();
        $table->string('emp_work')->nullable();
        $table->string('emp_mobile_no')->nullable();
        $table->double('emp_salary')->double(15,2)->nullable();
        $table->date('emp_joining_date')->nullable();
        $table->text('emp_address')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('employees');
    }
}
