<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
  protected $guarded = [];
  protected $table = 'purchase_order';
  public $timestamps = false;
  
  public static function getPurchaseOrders(){
    $po = PurchaseOrder::leftJoin('supplier','supplier.supplier_id','=','purchase_order.po_supplier_id')
            ->leftJoin('sites','sites.site_id','=','purchase_order.po_site_id')
            ->orderBy('po_date','DESC')->get();
    return $po;
  }
  
  public static function getOrderNo(){
    $po = PurchaseOrder::orderBy('po_id','DESC')->first();
    $account_no = '';
    if(count($po) > 0){
      $row_id = $po->po_id+1;
      $account_no = sprintf('%03d',$row_id);
    }else{
      $account_no = sprintf('%03d',1);
    }
    $account_no = "PORDR-".$account_no;
    return $account_no;
  }
}
