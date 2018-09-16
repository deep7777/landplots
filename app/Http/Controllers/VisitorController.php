<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Visitor;
use App\Sites;
use App\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
  
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    return view('/visitor/list_visitor');
  }
  
  public function listVisitor(){
    $data = $this->getData();
    return view('/visitor/list_visitor',$data);
  }
  function getData(){
    $visitor = Visitor::leftJoin('sites','sites.site_id','=','visitor.visitor_site_id')
                ->leftJoin('media','media.media_id','=','visitor.visitor_media_id')
                ->orderBy('visitor.visited_on','desc')
                ->get();
    $data = [
      'visitor_list'=>$visitor,
      'site_list'=>Sites::all(),
      'site_id'=>''
    ];
    return $data;
  }
  public function siteVisitor($site_id){
    $data = $this->getData();
    $visitor = Visitor::leftJoin('sites','sites.site_id','=','visitor.visitor_site_id')
                ->where('visitor.visitor_site_id',$site_id)
                ->get();
    $data['visitor_list'] = $visitor;
    $data['site_id'] = $site_id;
    return view('/visitor/list_visitor',$data);
  }
  
  public function addVisitor(){
    $data = [
        'sites_list' =>Sites::all(),
        'media_list' =>Media::all()
    ];
    return view('/visitor/add_visitor',$data);
  }
  
  public function editVisitor(Request $request){
     $id = $request->segment('1');

     $visitor = Visitor::leftJoin('sites','sites.site_id','=','visitor.visitor_site_id')
                ->leftJoin('media','media.media_id','=','visitor.visitor_media_id')
                ->where('id', $id)->first();
      $data = [
        'visitor' =>$visitor,
        'sites_list' =>Sites::all(), 
        'media_list'=>Media::all()
      ];
     if ($visitor) {
       return view('/visitor/edit_visitor',compact('visitor'),$data);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updateVisitor(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Visitor::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("/$id/editVisitor")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateVisitorRecord($request);
    }
    return redirect('/listVisitor');
  }
  
  public function createVisitor(Request $request,  Visitor $visitor){
    $rules = Visitor::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('/addVisitor')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveVisitor($request, $visitor);
    }
    return redirect('/listVisitor');
  }
  
  public function updateVisitorRecord($request){
    
    $id = $request->id;
    $date = Carbon::now()->format('Y-m-d H:i:s');
    $visited_on = ((isset($request->visited_on)==true))?$request->visited_on:$date;
    $update_visitor = array(
      'visitor_site_id' => ((isset($request->visitor_site_id)==true) && $request->visitor_site_id!='')?$request->visitor_site_id:0,
      'visitor_media_id' => ((isset($request->visitor_media_id)==true) && $request->visitor_media_id!='' )?$request->visitor_media_id:"0",  
      'first_name' => ucwords($request->first_name),
      'middle_name' => ucwords($request->middle_name),
      'last_name' => ucwords($request->last_name),
      'email' =>((isset($request->email)==true))?$request->email:"",
      'mobile_no' => $request->mobile_no,
      'address' =>  ((isset($request->address)==true))?$request->address:"",
      'visited_on' =>  $this->dateFormat($visited_on)
    );
    Visitor::find($id)->update($update_visitor);
  }
  
  public function saveVisitor($request,$visitor){
    $date = Carbon::now()->format('Y-m-d H:i:s');
    $visited_on = ((isset($request->visited_on)==true))?$request->visited_on:$date;
    $visitor->visitor_site_id = ((isset($request->visitor_site_id)==true) && $request->visitor_site_id!='')?$request->visitor_site_id:"0";
    $visitor->visitor_media_id = ((isset($request->visitor_media_id)==true) && $request->visitor_media_id!='')?$request->visitor_media_id:"0";
    $visitor->first_name = ucwords($request->first_name);
    $visitor->middle_name = ucwords($request->middle_name);
    $visitor->last_name = ucwords($request->last_name);
    $visitor->email = ((isset($request->email)==true))?$request->email:"";
    $visitor->mobile_no = $request->mobile_no;
    $visitor->address = ((isset($request->address)==true))?$request->address:"";
    $visitor->visited_on = $this->dateFormat($visited_on);
    $visitor->save();
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  public function deleteVisitor(Request $request){
    $id = $request->id;
    $visitor = Visitor::where('id', $id)->first();
    if ($visitor) {
      Visitor::destroy($id);
      return "success";
    }else{
      return "record not found";
    }
  }
  
  function getVisitorInfo(Request $request){
    $visitor_id =  $request->segment('2');
    $visitor = Visitor::where('id',$visitor_id)->first();
    if($visitor){
      echo json_encode($visitor);
      exit;
    }else{
      echo json_encode(array());
      exit;
    }
  }
}
