<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Sites;

class EmployeeController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $employees = Employee::leftJoin('sites','sites.site_id','=','employees.emp_site_id')->orderBy('emp_joining_date','desc')->get();
    $sites = Sites::all();
    $data = [
      'employees'=>$employees
    ];
    return view('/employee/list_employees',$data);
  }
  
  public function create(){
    $site_list = Sites::all();
    $data = [
      'site_list'=>$site_list  
    ];
    return view('/employee/add_employee',$data);
  }
  
  public function getInputs($request,$employee){
    $employee->emp_first_name = $request->emp_first_name;
    $employee->emp_last_name = $request->emp_last_name;
    if($request->emp_site_id!=""){
      $employee->emp_site_id = ($request->emp_site_id!="")?$request->emp_site_id:NULL;
    }
    $employee->emp_work = $request->emp_work;
    $employee->emp_mobile_no = $request->emp_mobile_no;
    $employee->emp_salary = ($request->emp_salary!="")?$request->emp_salary:NULL;;
    $employee->emp_joining_date = ($request->emp_joining_date!="")?$this->dateFormat($request->emp_joining_date):NULL;
    $employee->emp_address = $request->emp_address;
    return $employee;
  }
  
  public function store(Request $request){
    $employee = new Employee();
    $employee = $this->getInputs($request,$employee);
    $employee->save();
    return redirect('/employees');
  }
  
  public function edit(Request $request,$employee_id){
    $employee = Employee::where('emp_id',$employee_id)->first();
    $site_list = Sites::all();
    if($employee){
      $data = [
        'site_list'=>$site_list,   
        'employee'=>$employee
      ];
      return view('/employee/edit_employee',compact('employee'),$data);
    }else{
      return redirect('/employees');
    }
  }
  
  public function update(Request $request){
    $employee_record = new \stdClass();
    $employee_record->emp_id = $id = $request->emp_id;
    $employee_record = $this->getInputs($request,$employee_record);
    $employee = (array) $employee_record;
    Employee::where('emp_id', $id)->update($employee);
    return redirect('/employees');
  }
  
 
  public function destroy(Request $request){
    $id = $request->id;
    $emp = Employee::where('emp_id', $id)->first();
    if ($emp) {
      Employee::where('emp_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
