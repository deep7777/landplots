<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class SiteExpense extends Model
{
  protected $guarded = [];
  protected $table = 'site_expense';
  public $timestamps = false;
  
  public static function getAllVendors(){
    $qry = "select site_expense.* from site_expense group by site_expense_given_to;";
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
  public static function getSiteVendors($site_id){
    $query = "select site_expense.* from site_expense where site_id='{$site_id}' group by site_expense_given_to;";
    $query_obj = DB::select($query);
    return $query_obj;
  }
  
}
