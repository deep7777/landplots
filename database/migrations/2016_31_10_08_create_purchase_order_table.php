<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createPurchaseOrder();
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
    
    public function createPurchaseOrder()
    {
     
      Schema::create('purchase_order', function (Blueprint $table) {
        $table->increments('po_id');
        $table->string('po_number');
        $table->Integer('po_site_id')->length(10)->unsigned();
        $table->date('po_date')->nullable();
        $table->Integer('po_supplier_id');
        $table->string('po_reference')->nullable();
        $table->string('po_contact_person')->nullable();
        $table->string('po_site_contact')->nullable();
        $table->string('po_site_mobile')->nullable();
        $table->string('po_email')->nullable();
        $table->string('po_prepared_by')->nullable();
        $table->string('po_purchase_manager')->nullable();
        $table->text('po_billing_address')->nullable();
        $table->text('po_delivery_address')->nullable();
        $table->double('po_net_total_amount',15,2)->nullable();
        $table->double('po_grand_total_amount',15,2)->nullable();
        $table->double('po_tax_charge',8,2)->nullable();
        $table->double('po_total_tax',8,2)->nullable();
        $table->string('po_inwords')->nullable();
        $table->date('po_required_by_date')->nullable();
        $table->Integer('po_credit_days')->nullable();
        $table->Integer('po_status')->nullable();
      });
      
      Schema::table('purchase_order', function($table) {
        $table->foreign('po_site_id')->references('site_id')->on('sites');        
      });
    }
    /*
     * 
     */
    public function drop(){
      Schema::dropIfExists('purchase_order');
    }
}
