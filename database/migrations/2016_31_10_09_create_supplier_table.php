<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSupplier();
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
    
    public function createSupplier()
    {
     
      Schema::create('supplier', function (Blueprint $table) {
        $table->increments('supplier_id');
        $table->Integer('supplier_site_id')->nullable();
        $table->string('supplier_code')->nullable();
        $table->string('supplier_name')->nullable();
        $table->string('supplier_contact_person')->nullable();
        $table->Integer('supplier_credit_days')->nullable();
        $table->text('supplier_address')->nullable();
        $table->string('supplier_email')->nullable();
        $table->Integer('supplier_pincode')->nullable();
        $table->string('supplier_mobile_no')->nullable();
        $table->string('supplier_contact_person_no')->nullable();
        $table->string('supplier_vat')->nullable();
        $table->string('supplier_cst')->nullable();
        $table->string('supplier_pan')->nullable();
        $table->string('supplier_service_tax_no')->nullable();
        $table->string('supplier_opening_balance',15,2)->nullable();
        $table->string('supplier_closing_balance',15,2)->nullable();
        $table->string('supplier_status')->nullable();
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('supplier');
    }
}
