<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentModeToSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('salary', function($table) {
        $table->tinyInteger('salary_payment_mode')->nullable();
        $table->string('salary_payment_bank')->nullable();
        $table->string('salary_payment_cheque_number')->nullable();
        $table->date('salary_payment_cheque_date')->nullable();
        $table->string('salary_payment_transaction_id')->nullable();
      });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('salary', function($table) {
        $table->dropColumn('salary_payment_mode');
        $table->dropColumn('salary_payment_bank')->nullable();
        $table->dropColumn('salary_payment_cheque_number')->nullable();
        $table->dropColumn('salary_payment_cheque_date')->nullable();
        $table->dropColumn('salary_payment_transaction_id')->nullable();
      });
    }
}
