<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sites extends Model
{
  protected $fillable = [
    'site_name',
    'site_email',
    'site_contact_person',
    'site_mobile_no',
    'site_telephone_no',
    'site_address',
    'site_pincode',
    'site_area',
    'site_total',
    'site_cost',
    'site_plot_rate_per_sqft'
  ];
  protected $table = 'sites';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'site_name' => 'unique:sites'
    );
  }
  
  public static function updateRules($id){
    return array(
      'site_name' => "unique:sites,site_name,$id,site_id"
    );
  }
  
  public static function getContractorAmount($site_id){
    $query = "select sum(contractor_amount) as contractor_amount from contractor_customers where contractor_site_id='{$site_id}' group by contractor_site_id ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->contractor_amount;
    }else{
      return "0";
    }
  }
  
  public static function getTotalPlots($site_id){
    $total_plots = 0;
   
    $query = "select count(*) as total_plots from plots left join sites 
    on sites.site_id = plots.`site_id` where plots.site_id='{$site_id}' ";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_plots;
    }
   return $total_plots;
  }
  
  public static function getAvailablePlots($site_id){
    $available_plots = 0;
    $query = "select count(*) as available_plots from plots left join sites 
    on sites.site_id = plots.`site_id` where plots.site_id='{$site_id}'and plots.plot_booked='0'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->available_plots;
    }
    return $available_plots;
  }
  
  public static function getSoldPlots($site_id){
    $sold_plots = 0;
    $query = "select count(*) as sold_plots from plots left join sites 
    on sites.site_id = plots.`site_id` where plots.site_id='{$site_id}'and plots.plot_booked='1'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->sold_plots;
    }
    return $sold_plots;
  }
  
  public static function getSoldPlotsCollectedAmount($site_id){
    $query = "select sum(plot_payment.`plot_payment_amount`) as collected_amount
    from plot_payment 
    join plot_booking on `plot_payment`.`plot_booking_id` = plot_booking.`plot_booking_id`
    where plot_booking.site_id = '{$site_id}'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->collected_amount;
    }else{
      return 0;
    }
  }

  public static function getSoldPlotsTotalAmount($site_id){
    $query = "select sum(plot_booking.`plot_booking_cost`) as total_amount
    from plot_booking
    where plot_booking.site_id = '{$site_id}'";
    $query_obj = DB::select($query);
    if($query_obj){
      return $query_obj[0]->total_amount;
    }else{
      return 0;
    }
  }

  public static function getSummary(){
    $sites = Sites::all();
    $site_info = [];
    foreach($sites as $site){
      $site_id = $site->site_id;
      $record = array();
      $record['site_id'] = $site->site_id;
      $record['site_name'] = $site->site_name;
      $record['site_total_plots'] = self::getTotalPlots($site_id);
      $record['site_available_plots'] = self::getAvailablePlots($site_id);
      $record['site_sold_plots'] = self::getSoldPlots($site_id);
      $record['sold_plots_total_amount'] = self::getSoldPlotsTotalAmount($site_id);
      $record['sold_plots_collected_amount'] = self::getSoldPlotsCollectedAmount($site_id);
      $record['sold_plots_pending_amount'] = $record['sold_plots_total_amount'] - $record['sold_plots_collected_amount'];
      array_push($site_info,$record);
    }
    return $site_info;
  }
  
  public static function getAllSitePlots($site_id){
    $query = "select plots.plot_booked,plots.plot_no,plots.plot_area,sites.site_id,CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) as owner_name,plot_owner.owner_mobile_no,sites.site_name,plots.plot_no from plots 
    join sites on sites.site_id = plots.site_id 
    left join plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    left join plot_booking_owners on plot_booking_owners.plot_booking_id = plot_booking_owner_plots.plot_booking_id
    left join plot_owner on plot_owner.plot_booking_id = plot_booking_owners.plot_booking_id
    where sites.site_id='{$site_id}' order by sites.site_id,plots.plot_id asc";
    $all_plots = DB::select($query);
    return $all_plots;
  }
  
  public static function getAllSiteAvailablePlots($site_id){
    $query = "select plots.plot_booked,plots.plot_no,sites.site_id,CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) as owner_name,plot_owner.owner_mobile_no,sites.site_name,plots.plot_no from plots 
    join sites on sites.site_id = plots.site_id 
    left join plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    left join plot_booking_owners on plot_booking_owners.plot_booking_id = plot_booking_owner_plots.plot_booking_id
    left join plot_owner on plot_owner.plot_booking_id = plot_booking_owners.plot_booking_id
    where sites.site_id='{$site_id}' and plots.plot_booked='0' order by sites.site_id,plots.plot_id asc";
    $all_plots = DB::select($query);
    return $all_plots;
  }
  
  public static function getAllSiteBookedPlots($site_id){
    $query = "select plots.plot_booked,plots.plot_area,plots.plot_cost,plots.plot_no,sites.site_id,CONCAT(plot_owner.owner_first_name,' ',plot_owner.owner_last_name) as owner_name,plot_owner.owner_mobile_no,plot_booking.plot_booking_date,sites.site_name,plots.plot_no from plots 
    join sites on sites.site_id = plots.site_id 
    left join plot_booking_owner_plots on plot_booking_owner_plots.plot_id = plots.plot_id
    left join plot_booking_owners on plot_booking_owners.plot_booking_id = plot_booking_owner_plots.plot_booking_id
    left join plot_owner on plot_owner.plot_booking_id = plot_booking_owners.plot_booking_id
    left join plot_booking on plot_booking.plot_booking_id = plot_owner.plot_booking_id
    where sites.site_id='{$site_id}' and plots.plot_booked='1' order by sites.site_id,plots.plot_id asc";
    $all_plots = DB::select($query);
    return $all_plots;
  }

  public static function getSoldPlotsPercentage($site_id){
    $record =  array();
    $record['site_total_plots'] = self::getTotalPlots($site_id);
    $record['site_sold_plots'] = self::getSoldPlots($site_id);
    $per = 0;
    if($record['site_total_plots']){
      $per = ($record['site_sold_plots']/$record['site_total_plots'])*100;
    }
    return round($per); 
  }
}
