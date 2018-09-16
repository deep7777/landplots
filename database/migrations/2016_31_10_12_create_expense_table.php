<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $this->createExpense();
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
    
    public function createExpense()
    {
      Schema::create('expense', function (Blueprint $table) {
        $table->increments('expense_id');
        $table->string('expense_name')->nullable();
        $table->string('expense_given_to')->nullable();
        $table->string('expense_bill_no')->nullable();
        $table->tinyInteger('expense_payment_mode')->nullable();
        $table->string('expense_cheque_no')->nullable();
        $table->date('expense_cheque_date')->nullable();
        $table->string('expense_bank_name')->nullable();
        $table->string('expense_transaction_id')->nullable();
        $table->double('expense_amount')->double(15,2)->nullable();
        $table->text('expense_desc')->nullable();
        $table->date('expense_date')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('expense');
    }
}
