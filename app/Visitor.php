<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
  protected $fillable = ['visitor_site_id','visitor_media_id','first_name', 'last_name', 'email','mobile_no','address','purpose','vehicle_no','visited_on'];
  protected $table = 'visitor';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'mobile_no' => 'unique:visitor'
    );
  }
  
  public static function updateRules($id){
    return array(
      'mobile_no' => "unique:visitor,mobile_no,$id,id"
    );
  }
  
  public static function getList(){
    $visitor = Visitor::orderBy('visited_on','DESC')->get();
    return $visitor;
  }
}
