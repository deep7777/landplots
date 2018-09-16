<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\PlotBooking;
use App\PlotOwner;
use App\PlotOwnerPlots;
use App\PlotPayment;
use App\PlotBookingEmi;
use App\Plots;
use App\Salary;
use App\Sites;
use App\SiteExpense;
use App\Calculate;
use App\Reports;

class ReportsController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function listPlotBooking(){
    $site_list = Sites::all();
    $data = [
      'site_list' =>$site_list
    ];
    return view('reports/booking/list_plot_booking',$data);
  }


  public function getPlotBookingReport(Request $request){
    $selled_plots = Reports::getAllSoldPlots($request);
    $data = [
      'selled_plots'=>$selled_plots
    ];
    return view('reports/booking/list_plot_booking_data',$data);
  }

  public function listPlotPayments(){
    $sites = Sites::all();
    $data = [
      'sites'=>$sites
    ];
    return view("reports/bank/list_plot_payments",$data);
  }
  
  public function getPlotPaymentsReport(Request $request){
    $bank = PlotPayment::getPlotPaymentsReport($request);
    $data = [
      'bank_payments'=>$bank['bank_payments'],
      'total_payment'=>$bank['total_payment']
    ];
    return view("reports/bank/list_plot_payments_data",$data);
  }
  
  public function getYear(){
    $year = range(2015, 2050);
    return $year;
  }
  
  public function listEmployeeSalary(){
    $year = $this->getYear();
    $employees = Employee::all();
    $data = [
      'year'=>$year,
      'employees'=>$employees
    ];
    return view("reports/salary/list_employee_salary",$data);
  }
  
  public function getEmployeeSalaryReport(Request $request){
    $salary = Employee::getSalaryReport($request);
    $data = [
      'salary'=>$salary['employeeReport'],
      'total_salary'=>Calculate::getMoneyFormat($salary['total_salary'])
    ];
    return view("reports/salary/list_employee_salary_data",$data);
  }
  
  public function listSiteExpense(){
    $sites = Sites::all();
    $data = [
        'sites'=>$sites
    ];
    return view("reports/expense/list_site_expense",$data);
  }
  
  
  public function getSiteVendors(Request $request){
    $site_id = $request->site_id;
    $data = array("vendors"=>array());
    if($site_id!=''){
      $vendors = SiteExpense::getSiteVendors($site_id);
      $data = [
        'vendors'=>$vendors
      ];
    }
    return view("reports/expense/list_site_vendors",$data);
  }
  
  public function getSiteExpenseReport(Request $request){
    $data = array("site_expenses"=>array());
    $site_expenses = Reports::getSiteExpenseReport($request);
    $data = [
      'site_expenses'=>$site_expenses['site_expenses'],
      'total_site_expense'=>Calculate::getMoneyFormat($site_expenses['total_site_expense'])
    ];
    
    return view("reports/expense/list_site_expense_data",$data);
  }
  
  public function listCompanyExpense(){
    $sites = Sites::all();
    $expenses = Reports::getCompanyExpense();
    $data = [
        'expenses'=>$expenses,
        'sites'=>$sites
    ];
    return view("reports/expense/list_company_expense",$data);
  }
  
  public function getCompanyExpenseReport(Request $request){
    $data = array("company_expenses"=>array());
    $company_expenses = Reports::getCompanyExpenseReport($request);
    $data = [
      'company_expenses'=>$company_expenses['expenses'],
      'total_company_expense'=>Calculate::getMoneyFormat($company_expenses['total_company_expense'])
    ];
    
    return view("reports/expense/list_company_expense_data",$data);
  }

  public function listPaymentReminders(){
    $site_list = Sites::all();
    $input = array();
    $reminder = Reports::getPaymentReminders($input);
    $data = [
      'site_list' =>$site_list,
      'reminder' =>$reminder
    ];
    return view('reports/reminder/list_payment_reminder',$data);
  }


  public function getPaymentRemindersReport(Request $request){
    $reminder = Reports::getPaymentReminders($request);
    $data = [
      'reminder'=>$reminder
    ];
    return view('reports/reminder/list_payment_reminder_data',$data);
  }
  
}
