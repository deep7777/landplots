<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sites;
use App\SiteImages;
use App\Plots;
use App\PlotBooking;
use App\SiteExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    return view('site/list_site');
  }
  
  public function siteLayout($site_id){
    if($site_id!=''){
      $site = Sites::where('site_id',$site_id)->first();
      
      $active_image = Sites::leftJoin('site_images', 'site_images.image_site_id', '=', 'sites.site_id')
              ->where('site_id',$site_id)
              ->where('image_set_active',1)
              ->first();
      
      $site_list = Sites::getAllSitePlots($site_id);
      
      $available_plots = Sites::getAllSiteAvailablePlots($site_id);
      
      $sold_plots = Sites::getAllSiteBookedPlots($site_id);
      
      $data = [
          'active_image'=>$active_image,
          'site_list'=>$site_list,
          'site'=>$site,
          'available_plots'=>$available_plots,
          'sold_plots'=>$sold_plots
      ];
      return view('site/site_layout',$data);
    }else{
      return Redirect::to("/listSite");
    }
  }
  
  public function listSite(){
    $site_list = Sites::leftJoin('site_status','site_status.site_status_id','=','sites.site_status_id')
                ->get();
    return view('site/list_site',['site_list'=>$site_list]);
  }
  
  public function listSiteImages(){
    $site_list = Sites::all();
    $site_images = SiteImages::leftJoin('sites','sites.site_id','=','site_images.image_site_id')->get();
    $data = [
        'site_list' =>$site_list,
        'site_images'=>$site_images
    ];
    return view('site/list_site_images',$data);
  }
  
  public function addSiteImage(Request $request,$site_id){
    $site_list = Sites::all();
    $data = ['site_list'=>$site_list,'site_id'=>$site_id];
    return view("/site/add_site_image",$data);
  }
  
  
  public function siteInfo($site_id){
    $site_list = Sites::where('site_id',$site_id)->get();
    return view('site/list_site',['site_list'=>$site_list]);
  }
  
  public function addSite(){
    $site_status = \App\SiteStatus::all(); // completed || ongoing || future
    $site_list = Sites::all();
    $data = [
      'site_list'=>$site_list,  
      'site_id'=>'',
      'site_status' => $site_status
    ];
    return view("/site/add_site",$data);
  }
  
  public function editSite(Request $request){
      $id = $request->segment('1');
      $site_status = \App\SiteStatus::all(); // completed || ongoing || future
      $data = [
          'site_status' => $site_status
      ];
      $site = Sites::where('site_id', $id)->first();
      if ($site) {
        return view('site/edit_site',compact('site'),$data);
      }else{
        return view('errors/record_not_found',['msg'=>'Record not Found']);
      }
  }
  
  public function updateSite(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Sites::updateRules($id);
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("/$id/editSite")
          ->withErrors($validator)->withInput();
    }else{
      $this->updateSiteRecord($request);
    }
    return redirect('listSite');
  }
  
  public function createSite(Request $request,  Sites $site){
    $rules = Sites::createRules();
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Redirect::to('/addSite')
          ->withErrors($validator)->withInput();
    }else{
      $this->saveSite($request, $site);
    }
    return redirect('listSite');
  }
  
  public function updateSiteRecord($request){
    $id = $request->id;
    $site_cost = '0';
    if($request->site_area!='' && $request->site_plot_rate_per_sqft!=''){
      $site_cost = (float) $request->site_area * (int) $request->site_plot_rate_per_sqft;
    }
    $update_site = array(
      'site_name'=>ucwords($request->site_name),
      'site_email'=>$request->site_email,
      'site_contact_person'=>((isset($request->site_contact_person)==true))?ucwords($request->site_contact_person):"",
      'site_mobile_no'=>((isset($request->site_mobile_no)==true))?$request->site_mobile_no:"",
      'site_telephone_no'=>((isset($request->site_telephone_no)==true))?$request->site_telephone_no:"",
      'site_status_id'=>$request->site_status_id,  
      'site_address'=>((isset($request->site_address)==true))?$request->site_address:"",
      'site_pincode'=>((isset($request->site_pincode)==true))?$request->site_pincode:"",
      'site_area'=>((isset($request->site_area)==true))?$request->site_area:"",
      'site_total_plots'=>((isset($request->site_total_plots)==true))?$request->site_total_plots:"",
      'site_cost'=>$site_cost,
      'area_width_bottom'=>0,
      'area_width_top'=>0,
      'area_height_left'=>0,
      'area_height_right'=>0,
      'site_plot_rate_per_sqft' => ((isset($request->site_plot_rate_per_sqft)==true && $request->site_plot_rate_per_sqft!=''))?$request->site_plot_rate_per_sqft:"0",
      'created_on' => Carbon::now()->format('Y-m-d H:i:s'),
      'site_plots_area'=>(($request->site_plots_area!=''))?$request->site_plots_area:null,
      'site_road_area'=>(($request->site_road_area!=""))?$request->site_road_area:null  
    );
    Sites::where('site_id',$id)->update($update_site);
  }
  
  public function saveSite($request,$site){
    $site_cost = '0';
    if($request->site_area!='' && $request->site_plot_rate_per_sqft!=''){
      $site_cost = (float) $request->site_area * (int) $request->site_plot_rate_per_sqft;
    }
    $site->site_name = ucwords($request->site_name);
    $site->site_email = $request->site_email;
    $site->site_contact_person = ((isset($request->site_contact_person)==true))?ucwords($request->site_contact_person):"";
    $site->site_mobile_no = ((isset($request->site_mobile_no)==true))?$request->site_mobile_no:"";
    $site->site_telephone_no =((isset($request->site_telephone_no)==true))?$request->site_telephone_no:"";
    $site->site_status_id = $request->site_status_id;
    $site->site_pincode = ((isset($request->site_pincode)==true))?$request->site_pincode:"";
    $site->site_area = ((isset($request->site_area)==true))?$request->site_area:"";
    $site->site_total_plots = ((isset($request->site_total_plots)==true))?$request->site_total_plots:"";
    $site->site_cost = $site_cost;
    $site->site_plot_rate_per_sqft = ((isset($request->site_plot_rate_per_sqft)==true && $request->site_plot_rate_per_sqft!=''))?$request->site_plot_rate_per_sqft:"0";
    $site->created_on = Carbon::now()->format('Y-m-d H:i:s');
    $site->site_address = ((isset($request->site_address)==true))?$request->site_address:"";
    $site->area_width_bottom = 0;
    $site->area_width_top = 0;
    $site->area_height_left = 0;
    $site->area_height_right = 0;
    $site->site_plots_area = (($request->site_plots_area!=''))?$request->site_plots_area:null;
    $site->site_road_area=(($request->site_road_area!=""))?$request->site_road_area:null;
    $site->save();
  }
  
  public function deleteSite(Request $request){
    $id = $request->id;
    
    $msg = "";
    $plots = Plots::where('site_id',$id)->first();
    $plot_booking = Plots::where('site_id',$id)->first();
    $site_expense = SiteExpense::where('site_id',$id)->first();
    $site_images = SiteImages::where('image_site_id',$id)->first();
    if ($plots||$plot_booking||$site_expense||$site_images) {
      $msg.= "Cannot delete Site.\n";
      if($plots){
        $msg.= "Plots are already added for this site.\n";
      }
      if($plot_booking){
        $msg.= "Plots Booking is done for this site.\n";
      }
      if($site_expense){
        $msg.= "Expenses are added under this site.\n";
      }
      if($site_images){
        $msg.= "Site Images are added under this site.\n";
      }
    }
    
    if($msg==""){
      $site = Sites::where('site_id', $id)->first();
      if ($site) {
        Sites::where('site_id', $id)->delete();
        $msg = "success";
      }else{
        $msg = "record not found";
      }
    }
    return $msg;
  }
  
  public function uploadSiteImage(Request $request,  SiteImages $site_image){
      $this->validate($request, [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      $imageName = date("Ymdhis").'.'.$request->image->getClientOriginalExtension();
      if($imageName){
        $request->image->move(public_path('uploads/sites'), $imageName);
        $site_image =new SiteImages();
        $site_image->image_name = $imageName;
        $site_image->image_site_id = $request->site_id;
        $site_image->image_set_active = 0;   
        $site_image->save();
    	return back()
    		->with('success','Image Uploaded successfully.')
    		->with('path',$imageName);
      }
  }
  
  public function deleteFile($file_name){
    if(file_exists($file_name)){
      unlink($file_name);
      return true;
    }else{
      return false;
    }
  }
  
  public function deleteSiteImage(Request $request){
    $id = $request->id;
    $site_image = SiteImages::where('image_id',$id)->first();
    if($site_image){
      $image_path = public_path('uploads/sites/'.$site_image->image_name);
      $this->deleteFile($image_path);
      SiteImages::where('image_id', $id)->delete();
      return "success";
    }else{
      return "failure";
    }
  }
  
  public function updateSiteImageInActive($site_id){
    $siteImage = array(
      'image_set_active'=>'0'
    );
    SiteImages::where('image_site_id', $site_id)->update($siteImage);
  }
  
  public function updateSiteImageActive($id){
    $siteImage = array(
        'image_set_active'=>'1'
    );
    SiteImages::where('image_id', $id)->update($siteImage);
  }

  public function setSiteImageActive(Request $request){
    $id = $request->id;
    $site_image = SiteImages::where('image_id',$id)->first();
    if($site_image){
      $site_id = $site_image->image_site_id;
      $this->updateSiteImageInActive($site_id);
      $this->updateSiteImageActive($id);
      return "success";
    }else{
      return "failure";
    }
  }

  public function soldPlotsChartAttributes(){
    $header = array(
      "title"=>array("text"=>"Plots Sold","fontSize"=>24,"font"=>"open sans"),
      "subtitle"=>array("text"=>"Percentage of Plots Sold","color"=>"#999999","fontSize"=>12,"font"=>"open sans"),
      "titleSubtitlePadding"=>9
    );
    $footer_attr = array("color"=>"#999999","fontSize"=>10,"font"=>"open sans","location"=>"bottom-left");
    $size_attr = array("canvasWidth"=> 590,"pieOuterRadius"=> "90%");   
    $labels_attr =  array(
          "outer"=> array("pieDistance"=> 32),
          "inner"=> array("hideWhenLessThanPercentage"=> 3),
          "mainLabel"=> array("fontSize"=> 11),
          "percentage"=> array("color"=> "#ffffff","decimalPlaces"=> 0),
          "value"=> array("color"=> "#adadad","fontSize"=> 11),
          "lines"=> array("enabled"=> true),
          "truncation"=> array("enabled"=> true)
        );
    $effects_attr = array(
      "pullOutSegmentOnClick"=> array(
        "effect"=> "linear",
        "speed"=> 400,
        "size"=> 8
      )
    );

    $misc_attr = array(
      "gradient"=> array(
        "enabled"=> true,
        "percentage"=> 100
      )
    );

    $chart = array("header"=>$header,"footer"=>$footer_attr,"size"=>$size_attr,"data"=>"","labels"=>$labels_attr,
      "effects"=>$effects_attr,"misc"=>$misc_attr);
    return $chart;
  }

   
  public function getSiteSoldPlotsStats(Request $request){
    $sites = Sites::all();
    $site_info = [];
    $data = array(
      "sortOrder" => "value-desc",
      "content" => array()
    );
    $chart = array("type"=>"pie","columns"=>[]);
    foreach($sites as $site){
      $chart["columns"][$site->site_name] = Sites::getSoldPlotsPercentage($site->site_id);
    }
    $result = json_encode($chart);
    echo $result;
    exit;
  }
}
