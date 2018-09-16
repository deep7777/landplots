<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contractors;
use App\ContractorCustomers;
use App\Sites;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ContractorController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function listContractor(){
    $contractor = Contractors::all();
    return view('/contractor/list_contractor',['contractor_list'=>$contractor]);
  }
  
  public function getData(){
    $contractor_customers_list = ContractorCustomers::leftJoin('contractors', 'contractors.contractor_id', '=', 'contractor_customers.contractor_id')->orderBy('contractor_date','DESC')->get();
    $data = [
        'contractor_customers_list'=>$contractor_customers_list,
        'site_list'=>Sites::all(),
        'site_id'=>''
    ];
    return $data;
  }
  
  public function listContractorCustomer(){
    $data = $this->getData();
    return view('/contractor/list_contractor_customer',$data);
  }
  
  public function siteContractorCustomer($site_id){
    $data = $this->getData();
    $contractor_customers_list = ContractorCustomers::leftJoin('contractors', 'contractors.contractor_id', '=', 'contractor_customers.contractor_id')
            ->where('contractor_customers.contractor_site_id',$site_id)
            ->orderBy('contractor_date','DESC')->get();
    $data['contractor_customers_list']=$contractor_customers_list;
    $data['site_id'] = $site_id;
    return view('/contractor/list_contractor_customer',$data);
  }
  
  public function addContractor(){
    return view('/contractor/add_contractor');
  }
  
  public function addContractorCustomer(){
    $contractor_list = Contractors::all();
    $site_list = Sites::all();
    $data = [
        'contractor_list'=>$contractor_list,
        'site_list'=>$site_list
    ];
    return view('/contractor/add_contractor_customer',$data);
  }
  
  public function editContractor(Request $request){
     $id = $request->segment('1');
     $contractor = Contractors::where('contractor_id', $id)->first();
     if ($contractor) {
       return view('/contractor/edit_contractor',compact('contractors'),['contractor'=>$contractor]);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function editContractorCustomer(Request $request){
      $id = $request->segment('1');
      $site_list = Sites::all();
      
      $contractor_customer = ContractorCustomers::leftJoin('contractors', 'contractors.contractor_id', '=', 'contractor_customers.contractor_id')
              ->leftJoin('sites', 'sites.site_id', '=', 'contractor_customers.contractor_site_id')
              ->where('customer_id', $id)->first(); 
      $data = [
        'contractor_customer'=>$contractor_customer,
        'site_list'=>$site_list
      ];
      if ($contractor_customer) {
        return view('/contractor/edit_contractor_customer',compact('contractor_customers'),$data);
      }else{
        return view('errors/record_not_found',['msg'=>'Record not Found']);
      }
  }
  
  public function updateContractor(Request $request){
    $this->updateContractorRecord($request);
    return redirect('/listContractor');
  }
  
  public function updateContractorCustomer(Request $request){
    $this->updateContractorCustomerRecord($request);
    return redirect('/listContractorCustomer');
  }
  
  public function createContractor(Request $request,  Contractors $contractor){
    $this->saveContractor($request, $contractor);
    return redirect('/listContractor');
  }
  
  public function createContractorCustomer(Request $request,  ContractorCustomers $contractor_customer){
    $this->saveContractorCustomer($request, $contractor_customer);
    return redirect('/listContractorCustomer');
  }
  
  public function updateContractorRecord($request){
    $id = $request->id;
    $update_contractor = array(
      'contractor_first_name' => ucwords($request->contractor_first_name),
      'contractor_last_name' => ucwords($request->contractor_last_name),
      'contractor_email' =>$request->contractor_email,
      'contractor_mobile_no' => $request->contractor_mobile_no,
      'contractor_address' =>  $request->contractor_address,
      'created_on' => Carbon::now()->format('Y-m-d H:i:s')
    );
    Contractors::where('contractor_id', $id)->update($update_contractor);
  }
  
  public function updateContractorCustomerRecord($request){
    $id = $request->id;
    $update_contractor_customer = array(
      'contractor_id' => $request->contractor_id,
      'contractor_site_id' => $request->contractor_site_id,
      'contractor_work' => $request->contractor_work,
      'contractor_amount' =>((isset($request->contractor_amount)==true))?$request->contractor_amount:"",
      'contractor_paid_amount' => ((isset($request->contractor_paid_amount)==true))?$request->contractor_paid_amount:"",
      'contractor_date' => $this->dateFormat($request->contractor_date)
    );
    ContractorCustomers::where('customer_id', $id)->update($update_contractor_customer);
  }
  
  public function saveContractor($request,$contractor){
    $contractor->contractor_first_name = ucwords($request->contractor_first_name);
    $contractor->contractor_last_name = ucwords($request->contractor_last_name);
    $contractor->contractor_email = ((isset($request->contractor_email)==true))?$request->contractor_email:"";
    $contractor->contractor_mobile_no = ((isset($request->contractor_mobile_no)==true))?$request->contractor_mobile_no:"";
    $contractor->contractor_address = ((isset($request->contractor_address)==true))?$request->contractor_address:"";
    $contractor->created_on = Carbon::now()->format('Y-m-d H:i:s');
    $contractor->save();
  }
  
  public function saveContractorCustomer($request,$contractor){
    $contractor->contractor_id = $request->contractor_id;
    $contractor->contractor_site_id = $request->contractor_site_id;
    $contractor->contractor_work = $request->contractor_work;
    $contractor->contractor_amount = ((isset($request->contractor_amount)==true))?$request->contractor_amount:"";
    $contractor->contractor_paid_amount = ((isset($request->contractor_paid_amount)==true))?$request->contractor_paid_amount:"";
    $contractor->contractor_date = $this->dateFormat($request->contractor_date);
    $contractor->save();
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  
  public function deleteContractor(Request $request){
    $id = $request->id;
    $contractor_customer = ContractorCustomers::where('contractor_id', $id)->first();
    if ($contractor_customer) {
      return "Contractor Assigned to this customer.<br> Cannot Delete Record.<br> Delete Record from Assign Contractor.";
    }else{
      $contractor = Contractors::where('contractor_id', $id)->first();
      if ($contractor) {
        Contractors::where('contractor_id', $id)->delete();
        return "success";
      }else{
        return "record not found";
      }
    }
  }
  
  public function deleteContractorCustomer(Request $request){
    $id = $request->id;
    $contractor_customer = ContractorCustomers::where('customer_id', $id)->first();
    if ($contractor_customer) {
      ContractorCustomers::where('customer_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
