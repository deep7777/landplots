<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Company;
use App\PaymentMode;
class ExpenseController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $expenses = Expense::orderBy('expense_date','desc')->get();
    $data = [
        'expenses'=>$expenses
    ];
    return view('/expenses/list_expenses',$data);
  }
  
  public function create(){
    $payment_mode = PaymentMode::all();
    $data = [
      'payment_mode'=>$payment_mode
    ];
    return view('/expenses/add_expense',$data);
  }
  
  public function getInputs($request,$expense){
    $expense->expense_name = $request->expense_name;
    $expense->expense_given_to = $request->expense_given_to;
    $expense->expense_bill_no = $request->expense_bill_no;
    $expense->expense_payment_mode = $request->payment_mode;
    if($request->payment_mode=="1"){
      $expense->expense_cheque_date = null;
      $expense->expense_cheque_no = null;
      $expense->expense_bank_name = null;
      $expense->expense_transaction_id = null;
    }
    elseif($request->payment_mode=="2"){
      $expense->expense_cheque_date = (isset($request->cheque_date)==true)?$this->dateFormat($request->cheque_date):"";
      $expense->expense_bank_name = (isset($request->bank_name)==true)?$request->bank_name:"";
      $expense->expense_cheque_no = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $expense->expense_transaction_id = '';
    }
    elseif($request->payment_mode=="3"){
      $expense->expense_transaction_id = $request->transaction_id;
      $expense->expense_cheque_date = null;
      $expense->expense_cheque_no = null;
      $expense->expense_bank_name = null;
    }
    $expense->expense_amount = $request->expense_amount;
    $expense->expense_desc = $request->expense_desc;
    $expense->expense_date = $this->dateFormat($request->expense_date);
    return $expense;
  }
  
  public function store(Request $request){
    $expense = new Expense();
    $expense = $this->getInputs($request,$expense);
    $expense->save();
    return redirect('/expenses');
  }
  
  public function edit(Request $request,$expense){
    $expense = Expense::where('expense_id',$expense)->first();
    $payment_mode = PaymentMode::all();
    if($expense){
      $data = [
        'expense'=>$expense,
        'payment_mode'=>$payment_mode  
      ];
      return view('/expenses/edit_expense',compact('expense'),$data);
    }else{
      return redirect('/expenses');
    }
  }
  
  public function update(Request $request){
    $expense_record = new \stdClass();
    $expense_record->expense_id = $id = $request->expense_id;
    $expense_record = $this->getInputs($request,$expense_record);
    $expense = (array) $expense_record;
    Expense::where('expense_id', $id)->update($expense);
    return redirect('/expenses');
  }
  
 
  public function destroy(Request $request){
    $id = $request->id;
    $plot = Expense::where('expense_id', $id)->first();
    if ($plot) {
      Expense::where('expense_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
  
  public function getPaymentmode(Request $request){
    $payment_mode = $request->payment_mode;
    $data = [
      'payment_mode' =>$payment_mode
    ];
    echo view('/payment_mode/payment_mode',$data);
    exit;
  }
}
