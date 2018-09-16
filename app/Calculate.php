<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Calculate extends Model
{
  public static function getMoneyFormat($amount){
    if($amount!=0){
      $format = DB::select("select FORMAT($amount,0) as money_format");
      return $format[0]->money_format;
    }else{
      return $amount;
    }
  }
}
