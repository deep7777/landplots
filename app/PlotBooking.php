<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotBooking extends Model
{
  protected $guarded = [];
  protected $table = 'plot_booking';
  public $timestamps = false;
  
  public static function getPlotNo($booking_id){
    $booking_plots = PlotBooking::select('plots.plot_no')
            ->join('plot_booking_owner_plots','plot_booking_owner_plots.plot_booking_id','=','plot_booking.plot_booking_id')
            ->join('plots','plots.plot_id','=','plot_booking_owner_plots.plot_id')
            ->where('plot_booking.plot_booking_id',$booking_id)->get();
    $plots = [];
    foreach($booking_plots as $plot){
      array_push($plots,$plot->plot_no);
    }    
    $plot_no = implode(',',$plots);
    return $plot_no;
  }
  
  public static function getSiteName($booking_id){
    $site = PlotBooking::select('sites.site_name')
            ->join('sites','sites.site_id','=','plot_booking.site_id')
            ->where('plot_booking.plot_booking_id',$booking_id)
            ->first();
    if($site){
      return $site->site_name;
    }else{
      return "";
    }
  }


  public static function getInstallments($booking_id){
    $installments = PlotBookingEmi::where('plot_booking_id',$booking_id)->get();
    return $installments;
  }
  
  public static function getOwner($booking_id){
    $owner = PlotBookingOwners::join('plot_owner','plot_booking_owners.owner_id','=','plot_owner.owner_id')
              ->where('plot_booking_owners.plot_booking_id',$booking_id)->first();
    return $owner;
  }
  
  public static function getDownPayment($booking_id){
    $payment = PlotPayment::where('plot_booking_id',$booking_id)
               ->where('plot_payment_type','down_payment')->first();
    return $payment;
  }
}
