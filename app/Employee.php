<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
  protected $guarded = [];
  protected $table = 'employees';
  public $timestamps = false;
  
  public static function getFormatedDate($date){
    $date_format = '';
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date_format = $year."-".$month."-".$day;
    }
    return $date_format;
  }
  
  public static function getSalaryReport($request){
    $emp_id = $request->emp_id;
    $from_date = self::getFormatedDate($request->from_date);
    $to_date = self::getFormatedDate($request->to_date);
    $where_condition = "";
    $conditions = [];
    
    if($emp_id!=''){
      $qry = "salary.emp_id ='{$emp_id}'";
      array_push($conditions,$qry);
    }
    if($from_date!=''){
      $qry = "salary_paid_date >='{$from_date}'";
      array_push($conditions,$qry);
    }
    if($to_date!=''){
      $qry = "salary_paid_date <='{$to_date}'";
      array_push($conditions,$qry);
    }
    
    if(count($conditions) > 0){
      $conditions = implode(' and ', $conditions);
      $where_condition = "where $conditions";
    }
    
    $qry = "select concat(employees.emp_first_name,' ',employees.emp_last_name) as emp_name,salary.* 
            from salary join employees on salary.emp_id=employees.emp_id
            $where_condition
            order by salary_paid_date desc";
    $employeeReport = DB::select($qry);
    
    $total_salary_qry = "select sum(salary.salary_amount) as salary_amount
            from salary join employees on salary.emp_id=employees.emp_id
            $where_condition
            order by salary_paid_date desc";
    $total_salary = DB::select($total_salary_qry);
    
    $data = [
        'employeeReport'=>$employeeReport,
        'total_salary'=>$total_salary[0]->salary_amount
    ];
    return $data;
  }
}
