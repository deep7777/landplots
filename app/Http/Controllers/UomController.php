<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uom;

class UomController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    $uoms = Uom::all();
    $data = [
        'uoms'=>$uoms
    ];
    return view('/uoms/list_uoms',$data);
  }
  
  public function create(){
    return view('/uoms/add_uom');
  }
  
  public function getInputs($request,$uom){
    $uom->uom_name = $request->uom_name;
    $uom->uom_status = 0;
    return $uom;
  }
  
  public function store(Request $request){
    $uom = new Uom();
    $uom = $this->getInputs($request,$uom);
    $uom->save();
    return redirect('/uoms');
  }
  
  public function edit(Request $request,$uom){
    $uom = Uom::where('uom_id',$uom)->first();
    if($uom){
      $data = [
        'uom'=>$uom
      ];
      return view('/uoms/edit_uom',compact('uom'),$data);
    }else{
      return redirect('/uoms');
    }
  }
  
  public function update(Request $request){
    $uom_record = new \stdClass();
    $uom_record->uom_id = $id = $request->uom_id;
    $uom_record = $this->getInputs($request,$uom_record);
    $uom = (array) $uom_record;
    Uom::where('uom_id', $id)->update($uom);
    return redirect('/uoms');
  }
  
 
  public function destroy(Request $request){
    $id = $request->id;
    $plot = Uom::where('uom_id', $id)->first();
    if ($plot) {
      Uom::where('uom_id', $id)->delete();
      return "success";
    }else{
      return "record not found";
    }
  }
}
