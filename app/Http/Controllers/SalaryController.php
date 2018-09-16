<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary;
use App\Employee;
use App\PaymentMode;
class SalaryController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $salaries = Salary::leftJoin('employees','employees.emp_id','=','salary.emp_id')->orderBy('salary_paid_date','desc')->get();
    $salarys = Employee::all();
    $data = [
      'employees'=>$salarys,  
      'salaries'=>$salaries
    ];
    return view('/salary/list_salary',$data);
  }
  
  public function create(){
    $employees = Employee::all();
    $payment_mode = PaymentMode::all();
    $data = [
      'employees'=>$employees,
      'payment_mode'=>$payment_mode  
    ];
    return view('/salary/add_salary',$data);
  }
  
  public function getInputs($request,$salary){
    $salary->emp_id = $request->emp_id;
    $salary->salary_amount = $request->salary_amount;
    $salary->salary_paid_date = $this->dateFormat($request->salary_paid_date);
    $salary->salary_payment_mode = $request->payment_mode;
    if($request->payment_mode=="2"){
      $salary->salary_payment_bank = (isset($request->bank_name)==true)?$request->bank_name:"";
      $salary->salary_payment_cheque_number = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $salary->salary_payment_cheque_date = $this->dateFormat($request->cheque_date);
    }
    else if($request->payment_mode=="3"){
      $salary->salary_payment_transaction_id = $request->transaction_id;
      $salary->salary_payment_bank = "";
      $salary->salary_payment_cheque_number = "";
      $salary->salary_payment_cheque_date = "";
    }else{
      $salary->salary_payment_transaction_id = "";
      $salary->salary_payment_bank = "";
      $salary->salary_payment_cheque_number = "";
      $salary->salary_payment_cheque_date = "";
    }
    return $salary;
  }
  
  public function store(Request $request){
    $salary = new Salary();
    $salary = $this->getInputs($request,$salary);
    $salary->save();
    return redirect('/salaries');
  }
  
  public function edit(Request $request,$salary_id){
    $salary = Salary::where('salary_id',$salary_id)->first();
    $employees = Employee::all();
    $payment_mode = PaymentMode::all();
    if($salary){
      $data = [
        'salary'=>$salary,   
        'employees'=>$employees,
        'payment_mode'=>$payment_mode  
      ];
      return view('/salary/edit_salary',compact('salary'),$data);
    }else{
      return redirect('/salaries');
    }
  }
  
  public function update(Request $request){
    $salary_record = new \stdClass();
    $salary_record->salary_id = $id = $request->salary_id;
    $salary_record = $this->getInputs($request,$salary_record);
    $salary = (array) $salary_record;
    Salary::where('salary_id', $id)->update($salary);
    return redirect('/salaries');
  }
  
 
  public function destroy(Request $request){
    $id = $request->id;
    $salary = Salary::where('salary_id', $id)->first();
    if ($salary) {
      Salary::where('salary_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
