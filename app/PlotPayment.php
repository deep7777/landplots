<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PlotPayment extends Model
{
  protected $guarded = [];
  protected $table = 'plot_payment';
  public $timestamps = false;
  
  public static function getFormatedDate($date){
    $date_format = '';
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date_format = $year."-".$month."-".$day;
    }
    return $date_format;
  }
  public static function getPlotPaymentsReport($input){
    $site_id = $input->site_id;
    $from_date = self::getFormatedDate($input->from_date);
    $to_date = self::getFormatedDate($input->to_date);
    $where_condition = '';
    $conditions = [];
    if($site_id!=''){
      $qry = "plot_booking.site_id ='{$site_id}'";
      array_push($conditions,$qry);
    }
    if($from_date!=''){
      $qry = "plot_payment.plot_payment_date >='{$from_date}'";
      array_push($conditions,$qry);
    }
    if($to_date!=''){
      $qry = "plot_payment.plot_payment_date <='{$to_date}'";
      array_push($conditions,$qry);
    }
    if(count($conditions) > 0){
      $conditions = implode(' and ', $conditions);
      $where_condition = "where $conditions";
    }
    
    $qry = "select plot_booking.*,
            plot_payment.*,
            payment_mode.payment_mode_name as payment_mode,
            sites.site_name,
            (SELECT GROUP_CONCAT(CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) SEPARATOR ', ')  from plot_booking_owners 
            JOIN plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
            WHERE plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as plot_owner_name,
            (select GROUP_CONCAT(plot_owner.owner_mobile_no SEPARATOR ', ')  from plot_booking_owners 
            join plot_owner on plot_owner.owner_id = plot_booking_owners.owner_id
            where plot_booking_owners.plot_booking_id = plot_booking.plot_booking_id)  as mobile_number,
            site_name,
            (SELECT GROUP_CONCAT(plots.plot_no SEPARATOR ', ')  from plots 
            JOIN plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
            WHERE plot_booking_owner_plots.plot_booking_id = plot_booking.plot_booking_id)  as plot_no
            from plot_payment
            JOIN `plot_booking` on plot_booking.plot_booking_id = plot_payment.`plot_booking_id`
            JOIN payment_mode on plot_payment.plot_payment_mode = payment_mode.payment_mode_id
            JOIN sites on plot_booking.site_id = sites.site_id
            $where_condition
            ORDER BY `plot_payment`.`plot_payment_date` desc";
    $bank_payment = DB::select($qry);
    

    $sum_qry = "select sum(plot_payment_amount) as plot_payment_amount
                from plot_payment
                JOIN `plot_booking` on plot_booking.plot_booking_id = plot_payment.`plot_booking_id`
                $where_condition";
                
    $total_payment = DB::select($sum_qry);
    $result = array('bank_payments'=>$bank_payment,'total_payment'=>$total_payment[0]->plot_payment_amount);
    return $result;
  }
}
