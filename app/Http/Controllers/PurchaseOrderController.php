<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use App\PurchaseOrder;
use App\Company;
use App\Supplier;

class PurchaseOrderController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $purchase_orders = PurchaseOrder::getPurchaseOrders();
    $data = [
      'purchase_orders'=>$purchase_orders
    ];
    return view('/purchase_orders/list_purchase_order',$data);
  }
  
  public function create(){
    $site_list = Sites::all();
    $suppliers = Supplier::all();
    $po_no = PurchaseOrder::getOrderNo();
    $company = Company::first();
    $data = [
      'po_no'=>$po_no,  
      'company'=>$company,  
      'suppliers'=>$suppliers,  
      'site_list'=>$site_list
    ];
    return view('/purchase_orders/add_purchase_order',$data);
  }
  
  public function getInputs($request,$po){
    $po->po_number = $request->po_number;
    $po->po_site_id = $request->po_site_id;
    $po->po_date = $this->dateFormat($request->po_date);
    $po->po_prepared_by = $request->po_prepared_by;
    $po->po_supplier_id = $request->po_supplier_id;
    $po->po_contact_person = $request->po_contact_person;
    $po->po_email = $request->po_email;
    $po->po_site_mobile = $request->po_site_mobile;
    $po->po_contact_person = $request->po_contact_person;
    $po->po_site_mobile = $request->po_site_mobile;
    $po->po_credit_days = $request->po_credit_days;
    $po->po_required_by_date = $this->dateFormat($request->po_required_by_date);
    $po->po_billing_address = $request->po_billing_address;
    $po->po_delivery_address = $request->po_delivery_address;
    return $po;
  }
  
  public function store(Request $request){
    $po = new PurchaseOrder();
    $po = $this->getInputs($request,$po);
    $po_no = PurchaseOrder::getOrderNo();
    $po->po_number = $po_no; // if 2 people are creating then
    $po->save();
    return redirect('/purchaseorders');
  }
  
  public function edit(Request $request,$poid){
    $purchaseorder = PurchaseOrder::where('po_id',$poid)->first();
    $site_list = Sites::all();
    $suppliers = Supplier::all();
    $supplier = Supplier::where('supplier_id',$purchaseorder->po_supplier_id);
    $company = Company::first();
    if($purchaseorder){
      $data = [
        'po'=>$purchaseorder,
        'company'=>$company,  
        'suppliers'=>$suppliers,  
        'supplier'=>$supplier,  
        'site_list'=>$site_list  
      ];
      return view('/purchase_orders/edit_purchase_order',compact('purchaseorder'),$data);
    }else{
      return redirect('/purchaseorders');
    }
  }
  
  public function update(Request $request){
    $po_record = new \stdClass();
    $id = $request->po_id;
    $po_record = $this->getInputs($request,$po_record);
    $po = (array) $po_record;
    PurchaseOrder::where('po_id', $id)->update($po);
    return redirect('/purchaseorders');
  }
  
  public function show($id){
    echo "showsdsd".$id;
    exit;
  }
  
  public function destroy(Request $request){
    $id = $request->id;
    $po = PurchaseOrder::where('po_id', $id)->first();
    if ($po) {
      PurchaseOrder::where('po_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function getData(){
    $site_list = Sites::all();
    $purchase_orders = PurchaseOrder::all();
    $data = [
      'site_list'=>$site_list,
      'purchase_orders'=>$purchase_orders  
    ];
    return $data;
  }
  
  public function listPurchaseOrder(){
    $data = $this->getData();
    return view('purchase_order/list_purchase_order',$data);
  }
  
  public function addPurchaseOrder(Request $request,$site_id){
    $site = Sites::where('site_id',$site_id)->first();
    $data = [
      'site'=>$site  
    ];
    return view('purchase_order/add_purchase_order',$data);
  }
  
  
}
