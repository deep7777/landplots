<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
          
class Company extends Model
{

  protected $fillable = ['name', 'email', 'mobile_no','office_no','logo','pincode','address','created_on'];
  protected $table = 'company';
  public $timestamps = false;
  
  public static function createRules(){
    return array(
      'mobile_no' => 'unique:company',
      'name'=>'unique:company',
      'office_no'=>'unique:company',
    );
  }
  
  public static function updateRules($id){
    return array(
      'mobile_no' => "unique:company,mobile_no,$id,id",
      'name' => "unique:company,name,$id,id",
      'office_no' => "unique:company,office_no,$id,id"
    );
  }
  
  public static function getList(){
    $company = Company::orderBy('created_on','DESC')->get();
    return $company;
  }
}
