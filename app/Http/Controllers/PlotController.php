<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sites;
use App\Plots;
use App\Visitor;
use App\PlotOwner;
use App\PlotPayment;
use App\PaymentMode;
use App\PlotBookingEmi;
use App\PlotBooking;
use App\PlotBookingOwners;
use App\PlotBookingOwnerPlots;
use App\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PlotController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function index(){
    return view('plot/list_plot');
  }
  
  public function getOwnerName($owner){
    $owner_info = [];
    foreach($owner as $owner){
      array_push($owner_info,$owner->owner_first_name." ".$owner->owner_last_name);
    }
    return $owner_info;
  }
  
  public function plotPayment(Request $request,$booking_id){
    $booked_plot = PlotBooking::where('plot_booking_id',$booking_id)->first();
    if ($booked_plot) {
      $owner_info = PlotBookingOwners::join('plot_owner','plot_owner.owner_id','=','plot_booking_owners.owner_id')
              ->where('plot_booking_owners.plot_booking_id',$booking_id)
              ->get();
      $owner_name = $this->getOwnerName($owner_info);
      $owner = implode(', ',$owner_name);
      $balance_amount = PlotOwner::getBalanceAmount($booking_id);
      $plot_payments = PlotPayment::where("plot_booking_id",$booking_id)->orderBy("plot_payment_date","desc")->get();
      $payment_mode = PaymentMode::all();
      $installments = [];
      if($booked_plot->plot_emi_taken=="1"){
        $installments = PlotBookingEmi::where('plot_booking_id',$booking_id)->get();
      }
      $emi_status = array("1"=>"Paid","0"=>"UnPaid");
      $plot_no = PlotBooking::getPlotNo($booking_id);
      $site_name = PlotBooking::getSiteName($booking_id);
      $data = [
        'booked_plot'=>$booked_plot,
        'payment_mode'=>$payment_mode,
        'balance_amount'=>$balance_amount,
        'plot_payments'=>$plot_payments,
        'installments'=>$installments,
        "emi_status" =>$emi_status,
        "owner"=>$owner  ,
        "plot_no"=>$plot_no,
        "site_name"=>$site_name 
      ];
      return view('plot/plot_payment',compact('plot_owner'),$data);
    }
  }
  
  
  public function listPlot(){
    $data = $this->getData();
    return view('plot/list_plot',$data);
  }
  
  public function getData(){
    $site_list = Sites::all();
    $plot_list = Plots::leftJoin('sites', 'sites.site_id', '=', 'plots.site_id')
                 ->orderBy('sites.site_name','asc')->get(); 
    $data = [
        'plot_list'=>$plot_list,
        'site_list'=>$site_list,
        'site_id'=>''
      ];
    return $data;
  }
  
  public function sitePlots($site_id){
    $data = $this->getData();
    $plot_list = Plots::leftJoin('sites', 'sites.site_id', '=', 'plots.site_id')->where('plots.site_id',$site_id)->get(); 
    $data['plot_list'] = $plot_list;
    $data['site_id'] = $site_id;
    return view('plot/list_plot',$data);
  }
  
  public function getPlots($site_id){
    $data = $this->getData();
    $plot_list = Plots::where('plots.site_id',$site_id)->where('plots.plot_booked',0)->get(); 
    
    $data = [
        'plot_list'=>$plot_list
    ];
    echo view('plot/site_plots',$data);
    exit;
  }
  
  
  public function selectPlot(Request $request){
    $site_id =  $request->segment('2');
    $site = Sites::where('site_id',$site_id)->first();
    $plots = Plots::join('sites', 'sites.site_id', '=', 'plots.site_id')
            ->where('sites.site_id',$site_id)
            ->where('plots.plot_booked',0)
            ->get();
    $payment_mode = $this->getPaymentModeList();
    $visitors = Visitor::where('visitor_site_id',$site_id)->get();
    $data = [
      'site'=>$site,  
      'plots'=>$plots,
      'visitors'=>$visitors,
      'payment_mode'=>$payment_mode,
      'installments'=>[]
    ];
   
    return view('/plot/select_plot',$data);
  }
  
  public function allocatePlot(Request $request){
    $this->addBooking($request);
    
    return Redirect::to("/listPlotBooking");
  }
  
  public function getPlotBookingInputs($booking,$request){
    $booking->site_id = $request->site_id;
    $booking->plot_booking_date = $this->dateFormat($request->plot_booking_date);
    $booking->plot_booking_area = $request->plot_area;
    $booking->plot_booking_cost = $request->plot_total_cost;
    $booking->plot_booking_rate_per_sqft = $request->plot_rate;
    $booking->next_payment_date = $this->dateFormat($request->plot_next_payment_due_date);
    return $booking;
  }
  
  public function addBooking($request){
    
    //$this->bookPlot($request);
    //addBooking table plot_booking
    //addBookingPlots table plot_booking_owner_plots
    //addBookingPlotOwner table plot_owner
    //assignBookingPlotsToOwner 
    $site_id = $request->site_id;
    $plots = $request->plot_id;
    $plot_already_booked = false;
    foreach($plots as $plot_id){
      $is_plot_booked = PlotBookingOwnerPlots::where('plot_id',$plot_id)->first();
      if($is_plot_booked){
        $plot_already_booked = true;
      }
    }
    
    if(!$plot_already_booked){
      $plot_booking = new \App\PlotBooking();
      $booking = $this->getPlotBookingInputs($plot_booking,$request);
      $booking->save();
      $booking_id = $booking->id;
    }
    
    if($booking_id!=''){
      foreach($plots as $plot_id){
        $is_plot_booked = PlotBookingOwnerPlots::where('plot_id',$plot_id)->first();
        if(!$is_plot_booked){
          $plot_booking_owner_plots = new PlotBookingOwnerPlots();
          $plot_booking_owner_plots->plot_booking_id = $booking_id;
          $plot_booking_owner_plots->plot_id = $plot_id;
          $plot_booking_owner_plots->save();
          $this->updatePlotAsBooked($plot_id);
        }
      }
      
      $owner_id = $this->addBookingPlotOwner($booking_id,$request);
      if($owner_id!=''){
        $plot_booking_owner = new PlotBookingOwners();
        $plot_booking_owner->plot_booking_id = $booking_id;
        $plot_booking_owner->owner_id = $owner_id;
        $plot_booking_owner->save();
      }
      
      $this->addPlotPayment($request,$booking_id);
      if($request->plot_emi_taken==1){
        $this->plotEmiTaken($request,$booking_id);
        $this->plotBookedEmiScheme($request,$booking_id);
      }
      
    }
    return Redirect::to("/listPlotBooking");
  }
  
  public function updatePlotAsBooked($plot_id){
    $plot = new \stdClass();
    $plot->plot_booked = 1;
    $plot_record = (array) $plot;
    Plots::where('plot_id',$plot_id)->update($plot_record);
  }
  
  public function getBookingPlotOwnerInputs($owner,$request){
    $owner->owner_first_name = $request->first_name;
    $owner->owner_middle_name = $request->middle_name;
    $owner->owner_last_name = $request->last_name;
    $owner->owner_email = $request->email;
    $owner->owner_mobile_no = $request->mobile_no;
    $owner->owner_address = $request->address;
    return $owner;
  }
  
  public function addBookingPlotOwner($booking_id,$request){
    $plot_owner = new PlotOwner();
    $plot_owner->plot_booking_id = $booking_id;
    $owner = $this->getBookingPlotOwnerInputs($plot_owner,$request);
    $owner->save();
    return $owner->id;
  }
  
  public function salePlot(Request $request){
    $site_id = $request->site_id;
    $plot_id = $request->plot_id;
    $this->plotBooked($request);
    $this->plotEmiTaken($plot_id);
    $this->addPlotPayment($request);
    if($request->plot_emi_taken==1){
      $this->plotBookedEmiScheme($request,$plot_id);
    }
    return Redirect::to("/listPlotBooking");
  }
  
  public function plotBookedEmiScheme($request,$booking_id){
    for($i=0;$i<=$request->plot_emi_installments;$i++){
      $emi = new PlotBookingEmi();
      $emi->plot_booking_id = $booking_id;
      $emi->emi_amount = $request['emi_amount_'.$i];
      $emi->emi_date = $this->dateFormat($request['emi_date_'.$i]);
      $emi->save();
    }
  }
  
  
  
  public function updatePlotOwner($request){
    $owner_id = $request->owner_id;
    $owner = new \stdClass();
    $owner->plot_booking_id = $request->plot_booking_id;
    $owner_inputs = $this->getBookingPlotOwnerInputs($owner,$request);
    $owner_record = (array) $owner_inputs;     
    PlotOwner::where('owner_id', $owner_id)->update($owner_record);
  }
  
  public function getPlotPaymentInputs($payment,$request){
    $payment->plot_payment_type = "down_payment";
    $payment->plot_payment_mode = $request->payment_mode;
    $payment->plot_payment_per = $request->down_payment_per;
    $payment->plot_payment_amount = $request->down_payment_amount;
    $payment->plot_payment_date = $this->dateFormat($request->payment_date);
    if($request->payment_mode=="2"){
      $payment->plot_payment_bank = (isset($request->bank_name)==true)?$request->bank_name:"";
      $payment->plot_payment_cheque_number = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $payment->plot_payment_cheque_date = $this->dateFormat($request->cheque_date);
    }
    else if($request->payment_mode=="3"){
      $payment->plot_payment_transaction_id = $request->transaction_id;
      $payment->plot_payment_bank = "";
      $payment->plot_payment_cheque_number = "";
      $payment->plot_payment_cheque_date = "";
    }else{
      $payment->plot_payment_transaction_id = "";
      $payment->plot_payment_bank = "";
      $payment->plot_payment_cheque_number = "";
      $payment->plot_payment_cheque_date = "";
    }
    return $payment;
  }
  
  public function addPlotPayment($request,$booking_id){
    $payment = new PlotPayment();
    $payment->plot_booking_id = $booking_id;
    $plot_payment = $this->getPlotPaymentInputs($payment,$request);
    $plot_payment->save();
  }
  
  public function updatePlotPayment($request){
    $payment = new \stdClass();
    $payment->plot_booking_id = $request->plot_booking_id;
    $plot_payment = $this->getPlotPaymentInputs($payment,$request);
    $payment_record = (array) $plot_payment;      
    PlotPayment::where('plot_payment_id', $request->plot_payment_id)->update($payment_record);
  }
  
  public function updateBookedPlotPayment(Request $request){
    $booking_id = $request->plot_booking_id;
    $booking_plot = PlotBooking::where('plot_booking_id',$booking_id)->first();
    $payment = new PlotPayment();
    $payment->plot_booking_id = $booking_id;
    $payment->plot_payment_type = "installment";
    $payment->plot_payment_mode = $request->payment_mode;
    $payment->plot_payment_amount = $request->plot_payment_amount;
    $payment->plot_payment_date = $this->dateFormat($request->payment_date);
    if($request->payment_mode=="2"){
      $payment->plot_payment_bank = (isset($request->bank_name)==true)?$request->bank_name:"";
      $payment->plot_payment_cheque_number = (isset($request->cheque_number)==true)?$request->cheque_number:"";
      $payment->plot_payment_cheque_date = $this->dateFormat($request->cheque_date);
    }
    if($request->payment_mode=="3"){
      $payment->plot_payment_transaction_id = $request->transaction_id;
    }
    $payment->save();
    if($request->plot_next_payment_due_date!=''){
      $this->updateNextPaymentDueDate($booking_id,$request->plot_next_payment_due_date);
    }
    return back()->with('success',"Customer Plot Payment done."); 
  }
  
  
  public function plotEmiTaken($request,$booking_id){
    $booking = new \stdClass();
    $booking->plot_emi_taken =1;
    $booking->plot_emi_start_date = $this->dateFormat($request->plot_emi_start_date);
    $booking->plot_emi_installments = $request->plot_emi_installments;
    $booking_record = (array) $booking;
    PlotBooking::where('plot_booking_id', $booking_id)->update($booking_record);
  }
  
  
  public function updateNextPaymentDueDate($booking_id,$next_payment_due_date){
    $booking = new \stdClass();
    $booking->next_payment_date = $this->dateFormat($next_payment_due_date);
    $booking_record = (array) $booking;      
    PlotBooking::where('plot_booking_id', $booking_id)->update($booking_record);
  }
  
  public function updatePlotBooked($request){
    $plot_booking = new \stdClass();
    $booking = $this->getPlotBookingInputs($plot_booking,$request);
    $booking_record = (array) $booking;
    PlotBooking::where('plot_booking_id', $request->plot_booking_id)->where('site_id', $request->site_id)->update($booking_record);
  }
  
  public function updateBookedPlot(Request $request){
    $this->updatePlotBooked($request);
    $this->updatePlotOwner($request);
    $this->updatePlotPayment($request);
    return Redirect::to("/listPlotBooking");
  }
  
  public function getPaymentmode(Request $request){
    $payment_mode = $request->payment_mode;
    $data = [
        'payment_mode' =>$payment_mode
    ];
    echo view('/plot/payment_mode',$data);
    exit;
  }
  
  public function getDownPaymentAmount(Request $request){
    $plot_total_cost = $request->plot_total_cost;
    $result = array("down_payment_amount"=>"","balance_amount"=>"");
    if($plot_total_cost > 0 ){
      $down_payment_amount = $request->down_payment_amount;
      $balance_amount = $plot_total_cost - $down_payment_amount;
      $result = array("down_payment_amount"=>$down_payment_amount,"balance_amount"=>$balance_amount);
    }
    echo json_encode($result);
    exit;
  }
  
  public function getPlotCost(Request $request){
    $plot_area = $request->plot_area;
    $plot_rate = $request->plot_rate;
    $plot_basic_cost = $plot_area * $plot_rate;
    if($request->plot_service_tax!=''){
     $service_tax = $request->service_tax;
     $service_tax_cost = $plot_rate*($service_tax/100);
     $total_cost = $service_tax_cost + $plot_basic_cost;
    }else{
      $total_cost = $plot_basic_cost;
    }
    $result = array("plot_basic_cost"=>$plot_basic_cost,"plot_total_cost"=>$total_cost);
    echo json_encode($result);
    exit;
  }
  
  public function addSitePlot(Request $request,$site_id){
    $site_status = \App\SiteStatus::all(); // completed || ongoing || future
    $site_list = Sites::all();
    $data = [
        'site_id'=>$site_id,
        'site_status' => $site_status,
        'site_list'=>$site_list
    ];
    return view("/plot/add_site_plot",$data);
  }
  
  public function addPlot(){
    $site_list = Sites::all();
    $data = [
      'site_id'=>'',
      'site_list'=>$site_list
    ];
    return view("/plot/add_plot",$data);
  }
  
  public function editPlot(Request $request){
     $site_list = Sites::all();
     $id = $request->segment('1');
     $plot = Plots::leftJoin('sites', 'sites.site_id', '=', 'plots.site_id')->where('plot_id', $id)->first();
     if ($plot) {
       return view('plot/edit_plot',compact('plot'),['site_list'=>$site_list]);
     }else{
       return view('errors/record_not_found',['msg'=>'Record not Found']);
     }
  }
  
  public function updatePlot(Request $request){
    // create the validation rules ------------------------
    $id = $request->id;
    $rules = Plots::updateRules($id);
    $messages = Plots::ruleMessages($request);
    $site_plot_name = $request->site_id."".$request->plot_no;
    $validator = Validator::make(array('site_plot_name'=>$site_plot_name), $rules,$messages);
    if ($validator->fails()) {
      $id = $request->id;
      return Redirect::to("/$id/editPlot")
          ->withErrors($validator)->withInput();
    }else{
      $this->updatePlotRecord($request);
    }
    return redirect('listPlot');
  }
  
  public function createPlot(Request $request,  Plots $plot){
    
    if(isset($request["plotNumberSlider-enabled"]) && $request["plotNumberSlider-enabled"]=="1"){
      list($min,$max) = explode(",",$request["plotNumberSlider"]);
      $site_id = $request->site_id;
      for($i=$min;$i<=$max;$i++){
        $site_plot_name = $request->site_id."".$i;
        $plot_present = Plots::where('site_plot_name',$site_plot_name)->first();
        if(!$plot_present){
          $plot_cost = '0';
          if($request->plot_area!='' && $request->plot_rate_per_sqft!=''){
            $plot_cost = (float) $request->plot_area * (int) $request->plot_rate_per_sqft;
          }
          $plot = new Plots();
          $plot->site_id = $request->site_id;
          $plot->site_plot_name = $site_plot_name;
          $plot->plot_name = $i;
          $plot->plot_no = $i;
          $plot->plot_area = ((isset($request->plot_area)==true))?$request->plot_area:"";
          $plot->plot_rate_per_sqft = ((isset($request->plot_rate_per_sqft)==true && trim($request->plot_rate_per_sqft)!=''))?$request->plot_rate_per_sqft:"0";
          $plot->plot_cost = $plot_cost;
          $plot->plot_booked = '0';
          $plot->plot_basic_cost = 0;
          $plot->plot_service_tax = 0;
          $plot->updated_at = Carbon::now()->format('Y-m-d H:i:s');
          $plot->save();
        }
      }
    }else{
      $rules = Plots::createRules();
      $messages = Plots::ruleMessages($request);
      
      $site_plot_name = $request->site_id."".$request->plot_no;
      $validator = Validator::make(array('site_plot_name'=>$site_plot_name), $rules,$messages);
      if ($validator->fails()) {
        return Redirect::to('/addPlot')
            ->withErrors($validator)->withInput();
      }else{
        $this->savePlot($request, $plot);
      }
    }
    return redirect('listPlot');
  }
  
  public function updatePlotRecord($request){
    $id = $request->id;
    $plot_cost = '0';
    if($request->plot_area!='' && $request->plot_rate_per_sqft!=''){
      $plot_cost = (float) $request->plot_area * (int) $request->plot_rate_per_sqft;
    }
    $update_plot = array(
      'site_id'=>$request->site_id,
      'site_plot_name'=>$request->site_id."".$request->plot_no,
      'plot_address'=>((isset($request->plot_address)==true))?$request->plot_address:"",
      'plot_name'=>$request->plot_no,  
      'plot_no'=>$request->plot_no,
      'plot_area'=>((isset($request->plot_area)==true))?$request->plot_area:"",
      'plot_rate_per_sqft'=>((isset($request->plot_rate_per_sqft)==true && trim($request->plot_rate_per_sqft)!=''))?$request->plot_rate_per_sqft:"0",
      'plot_cost'=>$plot_cost,
      'plot_booked'=>$request->plot_booked,
      'plot_service_tax'=>0,
      'plot_basic_cost'=>0,  
      'created_at' => Carbon::now()->format('Y-m-d H:i:s')
    );
    Plots::where('plot_id', $id)->update($update_plot);
  }
  
  
  
  public function savePlot($request,$plot){
    $plot_cost = '0';
    if($request->plot_area!='' && $request->plot_rate_per_sqft!=''){
      $plot_cost = (float) $request->plot_area * (int) $request->plot_rate_per_sqft;
    }
    $plot->site_id = $request->site_id;
    $plot->site_plot_name = $request->site_id."".$request->plot_no;
    $plot->plot_name = $request->plot_no;
    $plot->plot_no = $request->plot_no;
    $plot->plot_area = ((isset($request->plot_area)==true))?$request->plot_area:"";
    $plot->plot_rate_per_sqft = ((isset($request->plot_rate_per_sqft)==true && trim($request->plot_rate_per_sqft)!=''))?$request->plot_rate_per_sqft:"0";
    $plot->plot_cost = $plot_cost;
    $plot->plot_booked = '0';
    $plot->plot_basic_cost = 0;
    $plot->plot_service_tax = 0;
    $plot->updated_at = Carbon::now()->format('Y-m-d H:i:s');
    $plot->save();
  }
  
  public function deletePlot(Request $request){
    $msg = "";
    $id = $request->id;
    $plot = Plots::where('plot_id', $id)->first();
    $plot_booking_owner_plots = PlotBookingOwnerPlots::where('plot_id',$id)->first();
    if($plot_booking_owner_plots){
      $msg.="Cannot delete plot.\n";
      $msg.="Plot is booked by owner.\n";
    }
    
    if($msg==""){
      if ($plot) {
        Plots::where('plot_id', $id)->delete();
        $msg = "success";
      }else{
        $msg = "record not found";
      }
    }
    return $msg;
  }
  
  public function listPlotBooking(){
    $site_list = Sites::all();
    $selled_plots = Plots::getAllSelledPlots();
    $data = [
      'site_list' =>$site_list,
      'selled_plots'=>$selled_plots
    ];
    return view('sales/list_plot_booking',$data);
  }
  
  public function getPaymentModeList(){
    $payment_mode = array(array("name"=>"cash","id"=>"1"),array("name"=>"cheque","id"=>"2"),array("name"=>"online","id"=>"3"));
    return $payment_mode;
  }
  
  
  
  public function editBookedPlot(Request $request,$booking_id){
    $booked_plot = PlotBooking::join('sites','sites.site_id','=','plot_booking.site_id')
                  ->where('plot_booking_id',$booking_id)->first();
    
    $plot_no = PlotBooking::getPlotNo($booking_id);
    
    if ($booked_plot) {
      $balance_amount = PlotOwner::getBalanceAmount($booking_id);
      $payment_mode = $this->getPaymentModeList();
      $installments = PlotBooking::getInstallments($booking_id);
      $booking_owner = PlotBooking::getOwner($booking_id);
      $plot_booking_payment =   PlotBooking::getDownPayment($booking_id);     
      $emi_status = array("1"=>"Paid","0"=>"UnPaid");
      $data = [
        'booked_plot'=>$booked_plot,
        'plot_no'=>$plot_no,
        'booking_owner'=>$booking_owner,
        'payment_mode'=>$payment_mode,
        'balance_amount'=>$balance_amount,
        'installments'=>$installments,
        'emi_status'=>$emi_status,
        'plot_booking_payment'=>$plot_booking_payment
      ];
      return view('plot/edit_booked_plot',compact('plot_owner'),$data);
    }else{
      return view("/listPlotBooking");
    }
  }
  
  public function addPlotBooking(){
    return view('plot/add_plot_booking',$data);
  }
  
  public function editPlotBooking(){
    return view('plot/edit_plot_booking',$data);
  }
  
  public function dateFormat($date){    
    if($date!=''){
      list($day,$month,$year) = explode("/",$date);
      $date = $year."-".$month."-".$day;
    }
    return $date;
  }
  
  public function getFirstInstallment($balance_amount){
    $emi_first_installment_amount = 0;
    if($balance_amount > 0){
      $emi_first_installment_amount = ($balance_amount/2);
    }
    return $emi_first_installment_amount;
  }
  
  public function getEmiInstallmentAmount($balance_amount,$number_of_emi_installments){
    $emi_installment_amount = 0;
    if($number_of_emi_installments > 1){
      $emi_installment_amount = (($balance_amount/2) / $number_of_emi_installments);
    }
    return $emi_installment_amount;
  }
  
  public function getBookingEmiInstallmentAmount($balance_amount,$number_of_emi_installments){
    $emi_installment_amount = 0;
    if($number_of_emi_installments > 0){
      $emi_installment_amount = (($balance_amount) / $number_of_emi_installments);
    }
    return $emi_installment_amount;
  }

  public function getEmiInstallments(Request $request){
    $date = $this->dateFormat($request->plot_emi_start_date);
    $number_of_emi_installments = $request->plot_emi_installments;
    $balance_amount = $request->balance_amount;
    $emi_first_installment_amount = $this->getFirstInstallment($balance_amount);
    $emi_installment_amount = $this->getEmiInstallmentAmount($balance_amount, $number_of_emi_installments);
    $installments = [];
    if($number_of_emi_installments > 1 && $date!=''){
      for($i=0;$i<$number_of_emi_installments+1;$i++){
        $emi_date = Plots::getEmiDates($date,$i);
        if($i==0){
          $record = array("emi_date_$i"=>$emi_date,"emi_amount_$i"=>$emi_first_installment_amount);
        }else{
          $record = array("emi_date_$i"=>$emi_date,"emi_amount_$i"=>$emi_installment_amount);
        }
        array_push($installments,$record);
      }
    }
    $data = [
      "installments"=>$installments
    ];
    echo view("plot/emi_installments",$data);
    exit;
  }

  //on click of EMI button
  public function getBookingEmiInstallments(Request $request){
    $date = $this->dateFormat($request->plot_emi_start_date);
    $number_of_emi_installments = $request->plot_emi_installments;
    $balance_amount = $request->balance_amount;
    $emi_installment_amount = $this->getBookingEmiInstallmentAmount($balance_amount, $number_of_emi_installments);
    $installments = [];
    if($number_of_emi_installments > 0 && $date!=''){
      for($i=0;$i<$number_of_emi_installments;$i++){
        $emi_date = Plots::getEmiDates($date,$i);
        $record = array("emi_date_$i"=>$emi_date,"emi_amount_$i"=>$emi_installment_amount);
        array_push($installments,$record);
      }
    }
    $data = [
      "installments"=>$installments
    ];

    echo view("plot/booking_emi_installments",$data);
    exit;
  }
  
  public function updateEmiStatus(Request $request){
    $emi_id = $request->emi_id;
    $owner_id = $request->owner_id;
    if($request->emi_status!=''){
      $emi = new \stdClass();
      $emi->emi_status = $request->emi_status;
      $emi_record = (array) $emi;
      PlotBookingEmi::where('emi_id',$emi_id)->update($emi_record);
    }
    echo "success";
    exit;
  }
  
  public function getPlotArea(Request $request){
    $plot_id = $request->plot_id;
    $area = Plots::getArea($plot_id);
    echo $area;
    exit;
  }

  public function getBookingInvoice(Request $request){
    $booking_id = $request->booking_id;
    $data = [];
    $booked_plot = Plots::getBookingInvoice($booking_id);
    $company = Company::first();
    $plot_payments = PlotPayment::where("plot_booking_id",$booking_id)->orderBy("plot_payment_date","desc")->get();
    $payment_mode = PaymentMode::all();
    $data = [
      'booked_plot'=>$booked_plot,
      'company'=>$company,
      'plot_payments'=>$plot_payments
    ];
    echo view("plot/invoice_booking_data",$data);
    exit;
    ;
  }
}