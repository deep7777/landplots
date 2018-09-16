<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reports extends Model
{
  public static function getFormatedDate($date){
    $date_format = '';
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date_format = $year."-".$month."-".$day;
    }
    return $date_format;
  }

  public static function getFormatedMonth($date){
    $date_format = '';
    if($date!=''){
      list($month,$year) = explode("/",$date);
      $date_format = $year."-".$month;
    }
    return $date_format;
  }
  
  
  public static function getSiteExpenseReport($input){
    $site_id = $input->site_id;
    $from_date = self::getFormatedDate($input->from_date);
    $to_date = self::getFormatedDate($input->to_date);
    $site_vendor = $input->site_vendor;
    $where_condition = "";
    
    $conditions = [];
    if($site_id!=''){
      $qry = "site_expense.site_id ='{$site_id}'";
      array_push($conditions,$qry);
    }
    if($from_date!=''){
      $qry = "site_expense.site_expense_date >='{$from_date}'";
      array_push($conditions,$qry);
    }
    if($to_date!=''){
      $qry = "site_expense.site_expense_date <='{$to_date}'";
      array_push($conditions,$qry);
    }
    if($site_vendor!=''){
      $qry = "site_expense_given_to='{$site_vendor}'";
      array_push($conditions,$qry);
    }
    
    if(count($conditions) > 0){
      $conditions = implode(' and ', $conditions);
      $where_condition = "where $conditions";
    }
    
    $qry = "select sites.site_name,site_expense.* from site_expense
            join sites on sites.site_id=site_expense.site_id
            $where_condition
            order by site_expense_date desc";
    $site_expenses = DB::select($qry);
    $total_qry = "select sum(site_expense.site_expense_amount) as site_expense_amount from site_expense
            join sites on sites.site_id=site_expense.site_id
            $where_condition
            order by site_expense_date desc";
    $site_expenses_total = DB::select($total_qry);
    
    $result = [
      'site_expenses'=>$site_expenses,
      'total_site_expense'=>$site_expenses_total[0]->site_expense_amount 
    ];
    return $result;
  }
  
  public static function getCompanyExpense(){
    $query = "select expense_name,expense_id from expense group by expense_name";
    $expenses = DB::select($query);
    return $expenses;
  }
  
  public static function getCompanyExpenseReport($input){
    $from_date = self::getFormatedDate($input->from_date);
    $to_date = self::getFormatedDate($input->to_date);
    $expense_name = $input->expense_name;
    $where_condition = "";
    $conditions = [];
    
    if($from_date!=''){
      $qry = "expense.expense_date >='{$from_date}'";
      array_push($conditions,$qry);
    }
    if($to_date!=''){
      $qry = "expense.expense_date <='{$to_date}'";
      array_push($conditions,$qry);
    }
    if($expense_name!=''){
      $qry = "expense_name='{$expense_name}'";
      array_push($conditions,$qry);
    }
    
    if(count($conditions) > 0){
      $conditions = implode(' and ', $conditions);
      $where_condition = "where $conditions";
    }
    
    $qry = "select * from expense
            $where_condition
            order by expense_date desc";
    $expenses = DB::select($qry);
    $total_qry = "select sum(expense.expense_amount) as expense_amount from expense
            $where_condition
            order by expense_date desc";
    $expenses_total = DB::select($total_qry);
    
    $result = [
      'expenses'=>$expenses,
      'total_company_expense'=>$expenses_total[0]->expense_amount 
    ];
    return $result;
  }

  public static function getAllSoldPlots($input){
    $site_id = $input->site_id;
    $from_date = self::getFormatedDate($input->from_date);
    $to_date = self::getFormatedDate($input->to_date);
    $where_condition = "";
    $conditions = [];
    
    if($site_id!=''){
      $qry = "plot_booking.site_id ='{$site_id}'";
      array_push($conditions,$qry);
    }

    if($from_date!=''){
      $qry = "plot_booking.plot_booking_date >='{$from_date}'";
      array_push($conditions,$qry);
    }

    if($to_date!=''){
      $qry = "plot_booking.plot_booking_date <='{$to_date}'";
      array_push($conditions,$qry);
    }
    
    
    if(count($conditions) > 0){
      $conditions = implode(' and ', $conditions);
      $where_condition = "where $conditions";
    }

    $query = "select plot_booking.*,
    (SELECT GROUP_CONCAT(CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) SEPARATOR ', ')  from plot_booking_owners 
    JOIN plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    WHERE plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as plot_owner_name,
    (select GROUP_CONCAT(plot_owner.owner_mobile_no SEPARATOR ', ')  from plot_booking_owners 
    join plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    where plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as mobile_number,
    site_name,
    (SELECT GROUP_CONCAT(plots.plot_no SEPARATOR ', ')  from plots 
    JOIN plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    WHERE plot_booking_owner_plots.plot_booking_id = plot_booking.plot_booking_id)  as plot_no,
    sum(plot_payment.plot_payment_amount) as paid_amount,
    (plot_booking.plot_booking_cost-sum(plot_payment.plot_payment_amount)) as balance_amount
    from plot_booking
    JOIN sites on plot_booking.site_id = sites.site_id
    JOIN plot_payment on plot_payment.plot_booking_id = plot_booking.plot_booking_id
    $where_condition
    GROUP BY plot_booking.plot_booking_id
    ORDER BY `plot_booking`.`plot_booking_date` desc";
      $selled_plots = DB::select($query);
    return $selled_plots;
  }

  public static function getPaymentReminders($input){
    $site_id = $month = '';
    $where_booking_condition = "";
    $where_emi_condition = "";

    $plot_booking_conditions = [];
    $plot_booking_emi_conditions = [];

    if(isset($input->site_id)){
      $site_id = $input->site_id;
    }

    if(isset($input->month)){
      $month = self::getFormatedMonth($input->month);
    }

    if($site_id!=''){
      $qry = "plot_booking.site_id ='{$site_id}'";
      array_push($plot_booking_conditions,$qry);
      array_push($plot_booking_emi_conditions,$qry);
    }

    if($month!=''){
      $next_payment_date = "plot_booking.`next_payment_date`  like '%$month%' ";
      $emi_payment_date = " plot_booking_emi.`emi_date`  like '%$month%' ";
      array_push($plot_booking_conditions,$next_payment_date);
      array_push($plot_booking_emi_conditions,$emi_payment_date);
    }else{
      $next_payment_date_not_empty = "plot_booking.next_payment_date !='' ";
      $emi_payment_date_not_empty = " plot_booking_emi.`emi_date` !=''";
      array_push($plot_booking_conditions,$next_payment_date_not_empty);
      array_push($plot_booking_emi_conditions,$emi_payment_date_not_empty);
    }

    if(count($plot_booking_conditions) > 0){
      $plot_booking_conditions = implode(' and ', $plot_booking_conditions);
      $where_booking_condition = "where $plot_booking_conditions";
    }

    if(count($plot_booking_emi_conditions) > 0){
      $plot_booking_emi_conditions = implode(' and ', $plot_booking_emi_conditions);
      $where_emi_condition = "where $plot_booking_emi_conditions";
    }

    $query = "select plot_booking.`next_payment_date` as enext_payment_date,plot_booking.*,
    (SELECT GROUP_CONCAT(CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) SEPARATOR ', ')  from plot_booking_owners 
    JOIN plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    WHERE plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as plot_owner_name,
    (select GROUP_CONCAT(plot_owner.owner_mobile_no SEPARATOR ', ')  from plot_booking_owners 
    join plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    where plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as mobile_number,
    site_name,
    (SELECT GROUP_CONCAT(plots.plot_no SEPARATOR ', ')  from plots 
    JOIN plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    WHERE plot_booking_owner_plots.plot_booking_id = plot_booking.plot_booking_id)  as plot_no,
    (select sum(plot_payment.plot_payment_amount) from plot_payment WHERE plot_payment.plot_booking_id = plot_booking.plot_booking_id) as plot_payment_amount,
    (plot_booking.plot_booking_cost-(select sum(plot_payment.plot_payment_amount) from plot_payment WHERE plot_payment.plot_booking_id = plot_booking.plot_booking_id))as balance_amount,
    plot_booking_emi.*
    from plot_booking
    JOIN sites on plot_booking.site_id = sites.site_id
    JOIN plot_payment on plot_payment.plot_booking_id = plot_booking.plot_booking_id
    left JOIN plot_booking_emi on plot_booking_emi.`plot_booking_id` =  plot_booking.plot_booking_id
    $where_booking_condition
    GROUP BY plot_booking.plot_booking_id
    UNION
    select plot_booking_emi.`emi_date` as next_payment_date,plot_booking.*,
    (SELECT GROUP_CONCAT(CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) SEPARATOR ', ')  from plot_booking_owners 
    JOIN plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    WHERE plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as plot_owner_name,
    (select GROUP_CONCAT(plot_owner.owner_mobile_no SEPARATOR ', ')  from plot_booking_owners 
    join plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
    where plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as mobile_number,
    site_name,
    (SELECT GROUP_CONCAT(plots.plot_no SEPARATOR ', ')  from plots 
    JOIN plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    WHERE plot_booking_owner_plots.plot_booking_id = plot_booking.plot_booking_id)  as plot_no,
    (select sum(plot_payment.plot_payment_amount) from plot_payment WHERE plot_payment.plot_booking_id = plot_booking.plot_booking_id) as plot_payment_amount,
    ((plot_booking.plot_booking_cost)-(select sum(plot_payment.plot_payment_amount) from plot_payment WHERE plot_payment.plot_booking_id = plot_booking.plot_booking_id))as balance_amount,
    plot_booking_emi.*
    from plot_booking
    JOIN sites on plot_booking.site_id = sites.site_id
    left JOIN plot_payment on plot_payment.plot_booking_id = plot_booking.plot_booking_id
    left JOIN plot_booking_emi on plot_booking_emi.`plot_booking_id` =  plot_booking.plot_booking_id
    $where_emi_condition
    GROUP BY plot_booking.plot_booking_id
    ORDER BY enext_payment_date desc";
    $reminders = DB::select($query);
    return $reminders;
  }
}
