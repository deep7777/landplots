<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
  public function __construct(Request $request){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    return view('admin/list_company');
  }
  
  public function listCompany(){
    $company = Company::all();
    $count = Company::count();
    $company_list = array();
    if($count > 0){
      foreach($company as $company){
        $company_list = $company;
      }
    }
    return view('admin/list_company',['company'=>$company_list,'count'=>$count]);
  }
  
  public function addCompany(){
    $count = Company::count();
    if($count == 0){
    return view('admin/add_company',['count'=>$count]);
    }else{
      return Redirect::to("/admin/listCompany");
    }
  }
  
  public function editCompany(Request $request){
     $id = $request->segment('2');
     $company = Company::where('id', $id)->first();
     if ($company) {
       return view('admin/edit_company',compact('company'));
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateCompany(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Company::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("admin/$id/editCompany")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateCompanyRecord($request);
    }
    return redirect('admin/listCompany');
  }
  
  public function createCompany(Request $request,  Company $company){
    $rules = Company::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('admin/addCompany')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveCompany($request, $company);
    }
    return redirect('admin/listCompany');
  }
  
  public function updateCompanyRecord($request){
    $office_no = ((isset($request->office_no)==true))?$request->office_no:"";
    $address = ((isset($request->address)==true))?$request->address:"";
    $id = $request->id;
    $update_company = array(
      'name' => $request->name,
      'email' => $request->email,
      'mobile_no' =>$request->mobile_no,
      'office_no' => $office_no,
      'pincode' => $request->pincode,
      'address' => $address,
      'created_on' => Carbon::now()->format('Y-m-d H:i:s')
    );
    Company::find($id)->update($update_company);
  }
  
  public function saveCompany($request,$company){
    $office_no = ((isset($request->office_no)==true))?$request->office_no:"";
    $address = ((isset($request->address)==true))?$request->address:"";
    $company->name = $request->name;
    $company->email = $request->email;
    $company->mobile_no = $request->mobile_no;
    $company->office_no = $office_no;
    $company->pincode = $request->pincode;
    $company->logo = "";
    $company->address = $address;
    $company->created_on = Carbon::now()->format('Y-m-d H:i:s');
    $company->save();
  }
  
  public function companyLogo(){
    $company = Company::all();
    $count = Company::count();
    $company_list = array();
    if($count > 0){
      foreach($company as $company){
        $company_list = $company;
      }
    }
    return view('admin/company_logo',['company'=>$company_list,'count'=>$count]); 
  }
  
  public function uploadCompanyLogo(Request $request){
      $this->validate($request, [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      $imageName = "company_pic".'.'.$request->image->getClientOriginalExtension();
      $request->image->move(public_path('uploads/logo'), $imageName);
      
      $id = $request->id;
      if(Company::findOrFail($id)){
        Company::where('id', $id)->update(array('logo' => $imageName));
      }

    	return back()
    		->with('success','Image Uploaded successfully.')
    		->with('path',$imageName);
  }
}
