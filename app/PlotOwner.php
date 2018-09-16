<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlotOwner extends Model
{
  protected $guarded = [];
  protected $table = 'plot_owner';
  public $timestamps = false;
  
  public static function getPaidAmount($booking_id){
    $query = "select sum(plot_payment_amount) as plot_payment_amount from plot_payment where plot_booking_id='{$booking_id}' ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->plot_payment_amount;
    }else{
      return "0";
    }
  }
  
  public static function getBookingCost($booking_id){
    $query = "select plot_booking_cost from plot_booking where plot_booking_id='{$booking_id}'";
    $query_obj = DB::select($query);
    $plot_cost = 0;
    if($query_obj){
      $plot_cost =  $query_obj[0]->plot_booking_cost;
    }
    return $plot_cost;
  }
  public static function getBalanceAmount($booking_id){
    $plot_cost = self::getBookingCost($booking_id);
    $paid_amount = self::getPaidAmount($booking_id);
    $balance_amount = $plot_cost - $paid_amount;
    return $balance_amount;
  }
}
