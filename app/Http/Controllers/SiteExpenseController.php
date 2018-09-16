<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use App\SiteExpense;
use App\PaymentMode;
class SiteExpenseController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $site_expenses = SiteExpense::leftJoin('sites', 'sites.site_id', '=', 'site_expense.site_id')
            ->orderBy('site_expense_date','desc')
            ->get();
    $data = [
        'site_expenses'=>$site_expenses
    ];
    return view('/site_expenses/list_siteexpenses',$data);
  }
  
  public function create(){
    $site_list = Sites::all();
    $payment_mode = PaymentMode::all();
    $data = [
      'site_list'=>$site_list,
      'payment_mode'=>$payment_mode
    ];
    return view('/site_expenses/add_site_expense',$data);
  }
  
  public function getInputs($request,$expense){
    $expense->site_expense_name = $request->expense_name;
    $expense->site_id = $request->site_id;
    $expense->site_expense_given_to = $request->site_expense_given_to;
    $expense->site_expense_bill_no = $request->site_expense_bill_no;
    $expense->site_expense_payment_mode = $request->payment_mode;
    if($request->payment_mode=="1"){
      $expense->site_expense_cheque_date = null;
      $expense->site_expense_cheque_no = null;
      $expense->site_expense_bank_name = null;
      $expense->site_expense_transaction_id = null;
    }
    elseif($request->payment_mode=="2"){
      $expense->site_expense_cheque_date = (isset($request->cheque_date)==true)?$this->dateFormat($request->cheque_date):"";
      $expense->site_expense_bank_name = (isset($request->bank_name)==true)?$request->bank_name:"";
      $expense->site_expense_cheque_no = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $expense->site_expense_transaction_id = '';
    }
    elseif($request->payment_mode=="3"){
      $expense->site_expense_transaction_id = $request->transaction_id;
      $expense->site_expense_cheque_date = null;
      $expense->site_expense_cheque_no = null;
      $expense->site_expense_bank_name = null;
    }
    $expense->site_expense_amount = $request->expense_amount;
    $expense->site_expense_desc = $request->expense_desc;
    $expense->site_expense_date = $this->dateFormat($request->expense_date);
    return $expense;
  }
  
  public function store(Request $request){
    $expense = new SiteExpense();
    $expense = $this->getInputs($request,$expense);
    $expense->save();
    return redirect('/siteexpenses');
  }
  
  public function edit(Request $request,$expense){
    $expense = SiteExpense::where('site_expense_id',$expense)->first();
    $site_list = Sites::all();
    $payment_mode = PaymentMode::all();
    if($expense){
      $data = [
        'site_list'=>$site_list,
        'site_expense'=>$expense,
        'payment_mode'=>$payment_mode  
      ];
      return view('/site_expenses/edit_site_expense',compact('expense'),$data);
    }else{
      return redirect('/siteexpenses');
    }
  }
  
  public function update(Request $request){
    $expense_record = new \stdClass();
    $expense_record->site_expense_id = $id = $request->site_expense_id;
    $expense_record = $this->getInputs($request,$expense_record);
    $expense = (array) $expense_record;
    SiteExpense::where('site_expense_id', $id)->update($expense);
    return redirect('/siteexpenses');
  }
  
 
  public function destroy(Request $request){
    $id = $request->id;
    $rec = SiteExpense::where('site_expense_id', $id)->first();
    if ($rec) {
      SiteExpense::where('site_expense_id', $id)->delete();
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
