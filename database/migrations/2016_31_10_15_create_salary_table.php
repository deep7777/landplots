<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $this->createSalary();
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
    
    public function createSalary()
    {
      Schema::create('salary', function (Blueprint $table) {
        $table->increments('salary_id');
        $table->Integer('emp_id');
        $table->double('salary_amount')->double(15,2)->nullable();
        $table->date('salary_paid_date')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('salary');
    }
}
