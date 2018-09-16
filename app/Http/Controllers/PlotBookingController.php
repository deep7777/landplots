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
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class PlotBookingController extends Controller
{
  public function __construct(){
    $this->middleware('userAuth');    
  }
  
  public function plotData(){
    //copy data from plot owner to plot booking
    $plot_owner = PlotOwner::join('plots','plot_owner.plot_id','=','plots.plot_id')->get();
    
    foreach($plot_owner as $plot){
      $plot_booking = new PlotBooking();
      $plot_booking->plot_booking_date = $plot->plot_booking_date;
      $plot_booking->plot_booking_area = $plot->plot_area;
      $plot_booking->plot_booking_rate_per_sqft = $plot->plot_rate_per_sqft;
      $plot_booking->plot_booking_cost = $plot->plot_cost;
      $plot_booking->save();
    }
    
    foreach($plot_owner as $plot){
      $plot_booking_owner = new PlotBookingOwners();
      $plot_booking_owner->plot_booking_id = $plot->owner_id;
      $plot_booking_owner->owner_id = $plot->owner_id;
      $plot_booking_owner->save();
    }
    
    foreach($plot_owner as $plot){
      $plot_owner_plot = new PlotBookingOwnerPlots();
      $plot_owner_plot->plot_booking_id = $plot->owner_id;
      $plot_owner_plot->plot_id = $plot->plot_id;
      $plot_owner_plot->save();
    }
    
    echo "Finished";
  }
  
  
  public function deleteBookingPlot(Request $request){
    $booking_id = $request->plot_booking_id;
    $this->deletePlotBookingOwnerPlots($booking_id);
    $this->deletePlotBookingOwners($booking_id);
    $this->deletePlotBookingEmi($booking_id);
    $this->deletePlotBookingPayment($booking_id);
    $this->deletePlotBooking($booking_id);
    echo "success";
    exit;
  }
  
  
  public function deletePlotBooking($booking_id){
    $booking = PlotBooking::where('plot_booking_id',$booking_id)->get();
    if($booking){
      PlotBooking::where('plot_booking_id',$booking_id)->delete();
    }
  }
  
  public function deletePlotBookingPayment($booking_id){
    $payment = PlotPayment::where('plot_booking_id',$booking_id)->get();
    foreach($payment as $payment){
      PlotPayment::where('plot_payment_id',$payment->plot_payment_id)->delete();
    }
  }
  
  public function deletePlotBookingEmi($booking_id){
    $booking = PlotBooking::where('plot_emi_taken','1')->where('plot_booking_id',$booking_id)->get();
    if($booking){
      $emis = PlotBookingEmi::where('plot_booking_id',$booking_id)->get();
      foreach($emis as $emi){
        PlotBookingEmi::where('emi_id',$emi->emi_id)->delete();
      }
    }
  }

  public function plotBookingEmi(Request $request,$booking_id){
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
      return view('plot/plot_booking_emi',$data);
    }
  }

  public function setEmi(Request $request){
    if($request->plot_emi_taken==1){
      $booking_id = $request->plot_booking_id;
      $this->plotEmiTaken($request,$booking_id);
      $this->plotBookedEmiScheme($request,$booking_id);
    }
    $result = array('status' => 'success');
    echo json_encode($result);
    exit;
  }

  public function plotBookedEmiScheme($request,$booking_id){
    //checkPreEmi's
    $plot_booking_emi = PlotBookingEmi::where('plot_booking_id',$booking_id)->first();
    if($plot_booking_emi){
      PlotBookingEmi::where('plot_booking_id',$booking_id)->delete();   
    }
    for($i=0;$i<$request->plot_emi_installments;$i++){
      $emi = new PlotBookingEmi();
      $emi->plot_booking_id = $booking_id;
      $emi->emi_amount = $request['emi_amount_'.$i];
      $emi->emi_date = $this->dateFormat($request['emi_date_'.$i]);
      $emi->save();
    }
  }

  public function plotEmiTaken($request,$booking_id){
    $booking = new \stdClass();
    $booking->plot_emi_taken =1;
    $booking->plot_emi_start_date = $this->dateFormat($request->plot_emi_start_date);
    $booking->plot_emi_installments = $request->plot_emi_installments;
    $booking->created_on = date('Y-m-d h:i:s');
    $booking_record = (array) $booking;
    PlotBooking::where('plot_booking_id', $booking_id)->update($booking_record);
  }

  public function getPaymentModeList(){
    $payment_mode = array(array("name"=>"cash","id"=>"1"),array("name"=>"cheque","id"=>"2"),array("name"=>"online","id"=>"3"));
    return $payment_mode;
  }
  
  public function deletePlotBookingOwners($booking_id){
    if($booking_id){
      $plots = PlotBookingOwners::where('plot_booking_id',$booking_id)->get();
      $owners = array();
      foreach($plots as $plot){
        $owner_id = $plot->owner_id;
        $owners[] = $owner_id;
        $plot_booking_owner = PlotBookingOwners::where('plot_booking_id',$booking_id)
                ->where('owner_id',$owner_id)->get();
        if($plot_booking_owner){
           PlotBookingOwners::where('plot_booking_id',$booking_id)
                ->where('owner_id',$owner_id)->delete();
        }
      }
      foreach($owners as $owner_id){
        $this->deleteOwnerRecord($owner_id);
      }
    }
  }
  
  public function deleteOwnerRecord($owner_id){
    $owner_record = PlotOwner::where('owner_id',$owner_id)->get();
    if($owner_record){
      PlotOwner::where('owner_id',$owner_id)->delete();
    }
  }
  
  public function deletePlotBookingOwnerPlots($booking_id){
    if($booking_id){
      $plots = PlotBookingOwnerPlots::where('plot_booking_id',$booking_id)->get();
      if($plots){
        foreach($plots as $plots){
          $this->unAssignBookedPlot($plots->plot_id);
          $this->deleteBookedPlot($booking_id,$plots->plot_id);
        }
      }
    }
  }
  
  public function unAssignBookedPlot($plot_id){
    $plot = new \stdClass();
    $plot->plot_booked = 0;
    $plot_record = (array) $plot;
    Plots::where('plot_id',$plot_id)->update($plot_record);
  }
  
  public function deleteBookedPlot($booking_id,$plot_id){
    $plot = PlotBookingOwnerPlots::where('plot_booking_id',$booking_id)
                                  ->where('plot_id',$plot_id)->get();
    if($plot){
      PlotBookingOwnerPlots::where('plot_booking_id',$booking_id)
                             ->where('plot_id',$plot_id)->delete();
    }
  }
  
  public function deletePlotPayment(Request $request){
    $plot_payment = PlotPayment::where('plot_payment_id',$request->plot_payment_id)->get();
    if($plot_payment){
      PlotPayment::where('plot_payment_id',$request->plot_payment_id)->delete();
      echo "success";
    }else{
      echo "failure";
    }
    exit;
  }
}
