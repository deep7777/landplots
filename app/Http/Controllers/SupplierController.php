<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sites;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $suppliers = Supplier::all();
    $data = [
        'suppliers'=>$suppliers
    ];
    return view('/suppliers/list_suppliers',$data);
  }
  
  public function create(){
    return view('/suppliers/add_supplier');
  }
  
  public function getInputs($request,$supplier){
    $supplier->supplier_name = $request->supplier_name;
    $supplier->supplier_mobile_no = $request->supplier_mobile_no;
    $supplier->supplier_contact_person = $request->supplier_contact_person;
    $supplier->supplier_contact_person_no = $request->supplier_contact_person_no;
    $supplier->supplier_email = $request->supplier_email;
    $supplier->supplier_pincode = $request->supplier_pincode;
    $supplier->supplier_cst = $request->supplier_cst;
    $supplier->supplier_pan = $request->supplier_pan;
    $supplier->supplier_vat = $request->supplier_vat;
    $supplier->supplier_service_tax_no = $request->supplier_service_tax_no;
    $supplier->supplier_address = $request->supplier_address;
    return $supplier;
  }
  
  public function store(Request $request){
    $supplier = new Supplier();
    $supplier = $this->getInputs($request,$supplier);
    $supplier->save();
    return redirect('/suppliers');
  }
  
  public function edit(Request $request,$supplier){
    $supplier = Supplier::where('supplier_id',$supplier)->first();
    if($supplier){
      $data = [
        'supplier'=>$supplier
      ];
      return view('/suppliers/edit_supplier',compact('supplier'),$data);
    }else{
      return redirect('/suppliers');
    }
  }
  
  public function update(Request $request){
    $supplier_record = new \stdClass();
    $supplier_record->supplier_id = $id = $request->supplier_id;
    $supplier_record = $this->getInputs($request,$supplier_record);
    $supplier = (array) $supplier_record;
    Supplier::where('supplier_id', $id)->update($supplier);
    return redirect('/suppliers');
  }
  
  public function show($id){
    echo "showsdsd".$id;
    exit;
  }
  
  public function destroy(Request $request){
    $id = $request->id;
    $plot = Supplier::where('supplier_id', $id)->first();
    if ($plot) {
      Supplier::where('supplier_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
