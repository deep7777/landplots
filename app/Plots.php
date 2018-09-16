<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plots extends Model
{
  
  protected $guarded = [];
  protected $table = 'plots';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'site_plot_name'=>"unique:plots"
    );
  }
  
  public static function updateRules($id){
    return array(
      'site_plot_name' => "unique:plots,site_plot_name,$id,plot_id"
    );
    
  }
  
  public static function ruleMessages($request){
    $msg_rules =[
      'site_plot_name.unique' => "Selected site plot $request->plot_name is already available.",
    ];
    return $msg_rules;
  }
  
  public static function deleteRules(){
    return array(
      'site_id' => "exists:plots,site_id"
    );
  }
  
  public static function deleteRuleMessages(){
    $msg = [
      'site_id.exists' => 'Site attached to Plots'
    ];
    return $msg;
  }
  
  public static function getAllSelledPlots(){

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
  GROUP BY plot_booking.plot_booking_id
  ORDER BY `plot_booking`.`plot_booking_date` desc";
    $selled_plots = DB::select($query);
    return $selled_plots;
  }
  
  public static function getEmiDates($date,$i){
    return self::getDateInterval($date, $i);
  }
  
  public static function getDateInterval($date,$interval){
    $query = "SELECT DATE_ADD('{$date}', INTERVAL $interval MONTH) as da";
    $query_obj = DB::select($query);
    return $query_obj[0]->da;
  }
  
  public static function getArea($plot_ids){
    
    $area = '';
    if($plot_ids){
      $ids = implode(",",$plot_ids);
      $query = "SELECT sum(plot_area) as plot_area from plots where plot_id in ($ids)";
      $query_obj = DB::select($query);
      $area = $query_obj[0]->plot_area;
    }
    return $area;
  }

  public static function getBookingInvoice($booking_id){

  $query = "select plot_booking.*,
  (SELECT GROUP_CONCAT(CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) SEPARATOR ', ')  from plot_booking_owners 
  JOIN plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
  WHERE plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as plot_owner_name,
  plot_owner.owner_address,
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
  JOIN plot_owner on plot_owner.plot_booking_id = plot_booking.plot_booking_id
  where plot_booking.plot_booking_id = '{$booking_id}'
  GROUP BY plot_booking.plot_booking_id";
    $booked_plot = DB::select($query)[0];
    return $booked_plot;
  }
}
