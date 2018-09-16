<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $guarded = [];
  protected $table = 'item';
  public $timestamps = false;
  
  public static function getItemNo(){
    $item = Item::orderBy('item_id','DESC')->first();
    $account_no = '';
    if(count($item) > 0){
      $row_id = $item->item_id+1;
      $account_no = sprintf('%03d',$row_id);
    }else{
      $account_no = sprintf('%03d',1);
    }
    $account_no = "ITEM-".$account_no;
    return $account_no;
  }
}
