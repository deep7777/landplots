<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $items = Item::all();
    $data = [
        'items'=>$items
    ];
    return view('/items/list_items',$data);
  }
  
  public function create(){
    $item_code = Item::getItemNo();
    $data = [
        'item_code' =>$item_code
    ];
    return view('/items/add_item',$data);
  }
  
  public function getInputs($request,$item){
    $item->item_name = $request->item_name;
    $item->item_code = $request->item_code;
    $item->item_desc = $request->item_desc;
    return $item;
  }
  
  public function store(Request $request){
    $item = new Item();
    $item = $this->getInputs($request,$item);
    $item->item_code = Item::getItemNo();
    $item->save();
    return redirect('/items');
  }
  
  public function edit(Request $request,$item){
    $item = Item::where('item_id',$item)->first();
    if($item){
      $data = [
        'item'=>$item
      ];
      return view('/items/edit_item',compact('item'),$data);
    }else{
      return redirect('/items');
    }
  }
  
  public function update(Request $request){
    $item_record = new \stdClass();
    $item_record->item_id = $id = $request->item_id;
    $item_record = $this->getInputs($request,$item_record);
    $item = (array) $item_record;
    Item::where('item_id', $id)->update($item);
    return redirect('/items');
  }
    
  public function destroy(Request $request){
    $id = $request->id;
    $plot = Item::where('item_id', $id)->first();
    if ($plot) {
      Item::where('item_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
