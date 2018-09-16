<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $this->createSiteExpense();
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
    
    public function createSiteExpense()
    {
      Schema::create('site_expense', function (Blueprint $table) {
        $table->increments('site_expense_id');
        $table->tinyInteger('site_id');
        $table->string('site_expense_name')->nullable();
        $table->string('site_expense_given_to')->nullable();
        $table->string('site_expense_bill_no')->nullable();
        $table->tinyInteger('site_expense_payment_mode')->nullable();
        $table->string('site_expense_cheque_no')->nullable();
        $table->date('site_expense_cheque_date')->nullable();
        $table->string('site_expense_bank_name')->nullable();
        $table->string('site_expense_transaction_id')->nullable();
        $table->double('site_expense_amount')->double(15,2)->nullable();
        $table->text('site_expense_desc')->nullable();
        $table->date('site_expense_date')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('site_expense');
    }
}
